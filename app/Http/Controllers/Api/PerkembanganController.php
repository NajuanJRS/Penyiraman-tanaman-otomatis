<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perkembangan;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PerkembanganController extends Controller
{
    public function index()
    {
        $perkembangan = Perkembangan::all();
        return response()->json([
            'message' => 'Data perkembangan berhasil diambil',
            'data' => $perkembangan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelembapan_tanah' => 'required|numeric|max:255',
            'kelembapan_udara' => 'required|numeric|max:255',
            'suhu' => 'required|numeric|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'kelembapan_tanah.required' => 'Kelembapan tanah harus diisi',
            'kelembapan_tanah.numeric' => 'Kelembapan tanah harus berupa angka',
            'kelembapan_udara.required' => 'Kelembapan udara harus diisi',
            'kelembapan_udara.numeric' => 'Kelembapan udara harus berupa angka',
            'suhu.required' => 'Suhu harus diisi',
            'suhu.numeric' => 'Suhu harus berupa angka',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // JIKA VALIDASI GAGAL
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Input tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = Storage::disk('public')->put('perkembangan', $request->file('gambar'));
        }

        $perkembangan = Perkembangan::create([
            'waktu' => now(),
            'kelembapan_tanah' => $request->kelembapan_tanah,
            'kelembapan_udara' => $request->kelembapan_udara,
            'suhu' => $request->suhu,
            'gambar' => $gambarPath,
        ]);

        $decision = $this->hitungKeputusan(
                $request->kelembapan_tanah,
                $request->kelembapan_udara,
                $request->suhu
            );

        // 🔥 3. Simpan ke tabel prediksi
        Prediksi::create([
            'id_perkembangan' => $perkembangan->id_perkembangan,
            'decision' => $decision
        ]);

        return response()->json([
            'message' => 'Data perkembangan berhasil disimpan',
            'data' => $perkembangan,
            'decision' => $decision
        ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage()
            ], 500);
        }

    }

        private function hitungKeputusan($tanah, $udara, $suhu)
        {
            if ($tanah < 60) {
                return 'Siram';
            } else {
                return 'Tidak Siram';
            }
        }

}
