<?php

namespace App\Http\Controllers;

use App\Models\Perkembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class PerkembanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $perkembangan = Perkembangan::with('prediksi')
        ->when($search, function ($query, $search) {
                return $query->where('waktu', 'like', "%{$search}%");
            })
            ->orderBy('id_perkembangan', 'desc')
            ->paginate(10);

        // AJAX REQUEST
        if ($request->ajax()) {

            return response()->json([

                'table' => view(
                    'partials.tableHistori',
                    compact('perkembangan')
                )->render(),

                'pagination' => $perkembangan->links()->render()

            ]);
        }

        return view('perkembangan', compact('perkembangan'));
    }

    public function export()
    {
        $data = Perkembangan::with('prediksi')
            ->orderBy('id_perkembangan', 'asc')
            ->get();

        $filename = "histori.csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Tambahkan BOM supaya Excel bisa baca UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header kolom
            fputcsv($file, [
                'Waktu',
                'Kelembapan Tanah (%)',
                'Kelembapan Udara (%)',
                'Suhu (°C)',
                'Keputusan'
            ], ';'); // gunakan titik koma

            foreach ($data as $d) {
                fputcsv($file, [
                    $d->waktu,
                    $d->kelembapan_tanah,
                    $d->kelembapan_udara,
                    $d->suhu,
                    $d->prediksi->decision ?? '-'
                ], ';'); // gunakan titik koma
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $perkembangan = Perkembangan::findOrFail($id);
        return view('editPerkembangan', compact('perkembangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240'
        ],
        [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.'
        ]);

        try {
            $perkembangan = Perkembangan::findOrFail($id);

            if ($request->hasFile('gambar')) {

                // Hapus gambar lama
                if ($perkembangan->gambar && Storage::disk('public')->exists($perkembangan->gambar)) {
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

                $savePath = storage_path(
                    'app/public/perkembangan/' . $filename
                );

                // Simpan hasil kompresi
                $encoded = $image->toJpeg(
                    quality: 85
                );

                file_put_contents(
                    $savePath,
                    $encoded
                );

                $perkembangan->gambar =
                    'perkembangan/' . $filename;

            }

            $perkembangan->save();

            return redirect('/histori')->with('success', 'Gambar berhasil diperbarui');

        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    public function hapusGambar($id)
    {
        $perkembangan = Perkembangan::findOrFail($id);

        // cek apakah ada gambar
        if ($perkembangan->gambar) {

            // hapus file dari storage
            if (Storage::disk('public')->exists($perkembangan->gambar)) {

                Storage::disk('public')->delete($perkembangan->gambar);
            }

            // kosongkan kolom gambar
            $perkembangan->gambar = null;

            $perkembangan->save();
        }

        return redirect('/histori')->with('success', 'Gambar berhasil dihapus');
    }
}
