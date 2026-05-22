<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KontrollerController;
use App\Http\Controllers\PerkembanganController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('checklogin')->group(function () {
Route::get('/', [DashboardController::class, 'index']);
Route::post('/siram', [DashboardController::class, 'siram'])
    ->name('kontrol.siram');
Route::get('kontrol', [KontrollerController::class, 'index']);
Route::post('kontrol/otomatis', [KontrollerController::class, 'otomatis'])->name('kontrol.otomatis');
Route::post('kontrol/manual', [KontrollerController::class, 'manual'])->name('kontrol.manual');
Route::post('kontrol/off', [KontrollerController::class, 'off'])->name('kontrol.off');
Route::get('histori', [PerkembanganController::class, 'index'])->name('histori');
Route::get('histori/export', [PerkembanganController::class, 'export'])->name('histori.export');
Route::get('histori/{id_perkembangan}/edit', [PerkembanganController::class, 'edit'])->name('histori.edit');
Route::put('histori/{id_perkembangan}', [PerkembanganController::class, 'update'])->name('histori.update');
Route::delete('/histori/{id}/hapus-gambar', [PerkembanganController::class, 'hapusGambar'])
    ->name('histori.hapusGambar');
});

