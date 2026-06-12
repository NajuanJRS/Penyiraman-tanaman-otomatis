<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KontrolController extends Controller
{
    public function index()
    {
        $kontrol = Kontroller::first();

        if (!$kontrol) {
            return response()->json([
                'status' => false,
                'message' => 'Data kontrol tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'mode_manual' => $kontrol->mode_manual,
            'mode_otomatis' => $kontrol->mode_otomatis,
            'batas_kelembapan' => $kontrol->batas_kelembapan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $kontroller = Kontroller::find($id);
        if (!$kontroller) {
            return response()->json([
                'message' => 'Kontrol tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'mode_otomatis' => 'required|boolean',
            'mode_manual' => 'required|boolean',
            'batas_kelembapan' => 'nullable|numeric|min:0|max:100',
        ], [
            'mode_otomatis.required' => 'Mode otomatis harus diisi',
            'mode_otomatis.boolean' => 'Mode otomatis harus berupa boolean',
            'mode_manual.required' => 'Mode manual harus diisi',
            'mode_manual.boolean' => 'Mode manual harus berupa boolean',
            'batas_kelembapan.numeric' => 'Batas kelembapan harus berupa angka',
            'batas_kelembapan.min' => 'Batas kelembapan minimal 0',
            'batas_kelembapan.max' => 'Batas kelembapan maksimal 100',
        ]);

        if ($validator->fails()) {
            return response()->json([
            'status' => false,
            'message' => 'Input tidak valid',
            'errors' => $validator->errors()
            ], 422);
        }

    try {
        $kontroller->update($request->only(['mode_otomatis', 'mode_manual', 'batas_kelembapan']));

        return response()->json([
            'message' => 'Kontrol berhasil diperbarui',
            'data' => $kontroller
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui kontrol',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
