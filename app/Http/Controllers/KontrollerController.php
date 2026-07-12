<?php

namespace App\Http\Controllers;

use App\Models\Kontroller;
use App\Models\Perkembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KontrollerController extends Controller
{
    public function index()
    {
        $kontrol = Kontroller::first();

        // Cek konektivitas ESP32: aktif jika data terakhir diterima dalam 15 menit
        $latestPerkembangan = Perkembangan::orderBy('id_perkembangan', 'desc')->first();
        $sistemAktif = $latestPerkembangan
            && $latestPerkembangan->waktu
            && Carbon::parse($latestPerkembangan->waktu)->greaterThanOrEqualTo(now()->subMinutes(15));

        return view('kontrol', [
            'mode_otomatis' => $kontrol->mode_otomatis ?? 1,
            'mode_manual' => $kontrol->mode_manual ?? 0,
            'sistemAktif' => $sistemAktif,
        ]);
    }

    public function otomatis()
{
    Kontroller::updateOrCreate(
        ['id_kontroller' => 1],
        [
            'mode_otomatis' => 1,
            'mode_manual' => 0
        ]
    );

    return redirect('kontrol')->with('success', 'Mode Otomatis Aktif');
    }

    public function manual()
    {
        Kontroller::updateOrCreate(
            ['id_kontroller' => 1],
            [
                'mode_otomatis' => 0,
                'mode_manual' => 1
            ]
        );

        return redirect('kontrol')->with('success', 'Mode Manual Aktif');
    }

    public function off()
    {
        Kontroller::updateOrCreate(
            ['id_kontroller' => 1],
            [
                'mode_otomatis' => 0,
                'mode_manual' => 0
            ]
        );

        return redirect('kontrol')->with('success', 'Semua Mode Dimatikan');
    }
}
