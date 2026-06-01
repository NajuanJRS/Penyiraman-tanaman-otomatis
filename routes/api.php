<?php

use App\Http\Controllers\Api\PerkembanganController as ApiPerkembanganController;
use App\Http\Controllers\Api\PrediksiController as ApiPrediksiController;
use App\Http\Controllers\Api\KontrolController as ApiKontrolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('apikey')->group(function () {
Route::get('/perkembangan', [ApiPerkembanganController::class, 'index']);

Route::post('/perkembangan', [ApiPerkembanganController::class, 'store']);

Route::post('/perkembangan/{id}/gambar', [ApiPerkembanganController::class, 'updateGambar']);

Route::delete('/perkembangan/{id}/gambar', [ApiPerkembanganController::class, 'hapusGambar']);

Route::get('/prediksi', [ApiPrediksiController::class, 'index']);

Route::post('/prediksi', [ApiPrediksiController::class, 'store']);

Route::get('/kontrol', [ApiKontrolController::class, 'index']);

Route::put('/kontrol/{id}', [ApiKontrolController::class, 'update']);
});
