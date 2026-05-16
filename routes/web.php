<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KontrollerController;
use App\Http\Controllers\PerkembanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);
Route::post('/siram', [DashboardController::class, 'siram'])
    ->name('kontrol.siram');
Route::get('kontrol', [KontrollerController::class, 'index']);
Route::post('kontrol/otomatis', [KontrollerController::class, 'otomatis']);
Route::post('kontrol/manual', [KontrollerController::class, 'manual']);
Route::post('kontrol/off', [KontrollerController::class, 'off']);
Route::get('histori', [PerkembanganController::class, 'index']);
Route::get('histori/export', [PerkembanganController::class, 'export']);
Route::get('histori/{id_perkembangan}/edit', [PerkembanganController::class, 'edit'])->name('histori.edit');
Route::put('histori/{id_perkembangan}', [PerkembanganController::class, 'update'])->name('histori.update');
