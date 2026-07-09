<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrediksiController extends Controller
{
    public function index()
    {
        $prediksi = Prediksi::all();
        return response()->json([
            'message' => 'Data prediksi berhasil diambil',
            'data' => $prediksi
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_perkembangan' => 'required|exists:perkembangan,id_perkembangan',
            'decision' => 'required|string',
        ], [
            'id_perkembangan.required' => 'Id perkembangan harus diisi',
            'id_perkembangan.exists' => 'Id perkembangan tidak valid',
            'decision.required' => 'Decision harus diisi',
            'decision.string' => 'Decision harus berupa string',
        ]);

        if ($validator->fails()) {
            return response()->json([
            'status' => false,
            'message' => 'Input tidak valid',
            'errors' => $validator->errors()
            ], 422);
        }

        try {
            $prediksi = Prediksi::create([
            'id_perkembangan' => $request->id_perkembangan,
            'decision' => $request->decision,
            ]);

            return response()->json([
            'message' => 'Data prediksi berhasil disimpan',
            'data' => $prediksi
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
            'status' => false,
            'message' => 'Gagal menyimpan data prediksi',
            'error' => $e->getMessage()
            ], 500);
        }
    }

    public function terakhir()
    {
        $prediksi = Prediksi::orderBy('id_prediksi', 'desc')->first();

        if (!$prediksi) {
            return response()->json([
                'message' => 'Belum ada data prediksi',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Data prediksi terakhir berhasil diambil',
            'data' => $prediksi
        ]);
    }
}
