<?php

namespace App\Http\Controllers;

use App\Models\Kontroller;
use App\Models\Perkembangan;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $latestPerkembangan = Perkembangan::orderBy('id_perkembangan', 'desc')->first();
        $latestPrediksi = Prediksi::orderBy('id_prediksi', 'desc')->first();

        // Status pompa
        $status = ($latestPrediksi && $latestPrediksi->decision == 'Siram') ? 'Aktif' : 'Mati';

        // 🔥 Ambil data TANPA GROUP (biar banyak titik)
        $grafik = Perkembangan::where('waktu', '>=', now()->subMonth())
            ->orderBy('waktu', 'asc')
            ->get();

        // 🔥 Format data untuk Chart.js (x,y)
        $chartTanah = [];
        $chartUdara = [];
        $chartSuhu = [];

        foreach ($grafik as $g) {
            $chartTanah[] = [
                'x' => $g->waktu,
                'y' => $g->kelembapan_tanah
            ];

            $chartUdara[] = [
                'x' => $g->waktu,
                'y' => $g->kelembapan_udara
            ];

            $chartSuhu[] = [
                'x' => $g->waktu,
                'y' => $g->suhu
            ];
        }

        // 🔥 Ambil periode bulan & tahun
        $periode = $grafik->isNotEmpty()
            ? Carbon::parse($grafik->last()->waktu)->translatedFormat('F Y')
            : '-';

        return view('dashboard', [
            'tanah' => $latestPerkembangan->kelembapan_tanah ?? 0,
            'udara' => $latestPerkembangan->kelembapan_udara ?? 0,
            'suhu' => $latestPerkembangan->suhu ?? 0,
            'decision' => $latestPrediksi->decision ?? 'Tidak Siram',
            'status' => $status,

            // 🔥 kirim data baru (BUKAN labels lagi)
            'chartTanah' => $chartTanah,
            'chartUdara' => $chartUdara,
            'chartSuhu' => $chartSuhu,

            'periode' => $periode,
        ]);
    }

    public function siram()
    {
        // Ambil data kontrol pertama
        $kontrol = Kontroller::first();

        if (!$kontrol) {
            return back()->with('error', 'Data kontrol tidak ditemukan');
        }

        // Aktifkan mode manual
        $kontrol->mode_manual = 1;
        $kontrol->save();

        // Tunggu 8 detik
        sleep(8);

        // Matikan kembali
        $kontrol->mode_manual = 0;
        $kontrol->save();

        return back()->with('success', 'Pompa berhasil dijalankan selama 8 detik');
    }
}
