<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perkembangan;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use App\Models\FcmToken;
use App\Models\Kontroller;
use App\Services\FirebaseNotificationService;
use Kreait\Firebase\Messaging\AndroidConfig;

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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'kelembapan_tanah.required' => 'Kelembapan tanah harus diisi',
            'kelembapan_tanah.numeric' => 'Kelembapan tanah harus berupa angka',
            'kelembapan_udara.required' => 'Kelembapan udara harus diisi',
            'kelembapan_udara.numeric' => 'Kelembapan udara harus berupa angka',
            'suhu.required' => 'Suhu harus diisi',
            'suhu.numeric' => 'Suhu harus berupa angka',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
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
            $image = Image::read(
                $request->file('gambar')
            );

            $image->scale(
                width: 1600
            );

            $filename =
                Str::uuid() . '.jpg';
            $path =
                storage_path(
                    'app/public/perkembangan/' . $filename
                );

            $image->toJpeg(
                quality: 85
            )->save($path);

            $gambarPath =
                'perkembangan/' . $filename;
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

        $lastPrediksi = Prediksi::orderByDesc(
            'id_prediksi'
        )->first();

        // if (
        //     $decision === 'Siram' &&
        //     (
        //         !$lastPrediksi ||
        //         $lastPrediksi->decision !== 'Siram'
        //     )
        // ) {

        //     $tokens = FcmToken::all();

        //     foreach ($tokens as $token) {

        //         $this->firebase->send(
        //             $token->token,
        //             'Caba.IoT',
        //             'Tanaman perlu disiram. Periksa status penyiraman.'
        //         );
        //     }
        // }

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

    public function updateGambar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $perkembangan = Perkembangan::findOrFail($id);

            // Hapus gambar lama
            if (
                $perkembangan->gambar &&
                Storage::disk('public')->exists($perkembangan->gambar)
            ) {
                Storage::disk('public')->delete($perkembangan->gambar);
            }

            // Kompres gambar baru
            $image = Image::read(
                $request->file('gambar')
            );

            // Resize jika terlalu besar
            $image->scale(
                width: 1600
            );

            $filename = Str::uuid() . '.jpg';

            $path = storage_path(
                'app/public/perkembangan/' . $filename
            );

            // Simpan sebagai JPG terkompresi
            $image->toJpeg(
                quality: 85
            )->save($path);

            $path = 'perkembangan/' . $filename;

            $perkembangan->gambar = $path;
            $perkembangan->save();

            return response()->json([
                'status' => true,
                'message' => 'Gambar berhasil diperbarui',
                'data' => $perkembangan
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    private FirebaseNotificationService $firebase;

    public function __construct(
        FirebaseNotificationService $firebase
    ){
        $this->firebase = $firebase;
    }

    public function hapusGambar($id)
    {
        try {

            $perkembangan = Perkembangan::findOrFail($id);

            if (
                $perkembangan->gambar &&
                Storage::disk('public')->exists($perkembangan->gambar)
            ) {
                Storage::disk('public')->delete($perkembangan->gambar);
            }

            $perkembangan->gambar = null;
            $perkembangan->save();

            return response()->json([
                'status' => true,
                'message' => 'Gambar berhasil dihapus'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    private function hitungKeputusan($tanah, $udara, $suhu)
    {
        $kontrol = Kontroller::first();

        $batas = $kontrol->batas_kelembapan ?? 40;

        if ($tanah <= $batas) {
            return 'Siram';
        }

        return 'Tidak Siram';
    }

}
