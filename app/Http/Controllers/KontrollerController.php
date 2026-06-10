<?php

namespace App\Http\Controllers;

use App\Models\Kontroller;
use Illuminate\Http\Request;

class KontrollerController extends Controller
{
    public function index()
    {
        $kontrol = Kontroller::first();

        return view('kontrol', [
            'mode_otomatis' => $kontrol->mode_otomatis ?? 1,
            'mode_manual' => $kontrol->mode_manual ?? 0,
            'batas_kelembapan' => $kontrol->batas_kelembapan ?? 40,
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

    public function updateThreshold(Request $request)
    {
        $request->validate([
            'batas_kelembapan' =>
                'required|integer|min:0|max:100'
        ]);

        Kontroller::updateOrCreate(
            ['id_kontroller' => 1],
            [
                'batas_kelembapan' =>
                    $request->batas_kelembapan
            ]
        );

        return back()->with(
            'success',
            'Batas kelembapan berhasil diperbarui'
        );
    }
}
