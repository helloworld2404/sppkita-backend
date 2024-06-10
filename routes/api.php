<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembayaranKelasController;
use App\Http\Controllers\PembayaranSiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswakelasController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\SiswaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('pembayaran', [PembayaranController::class, 'index']);
Route::post('pembayaran', [PembayaranController::class, 'store']);
Route::get('pembayaran/{id}', [PembayaranController::class, 'show']);
Route::post('pembayaran/create', [PembayaranController::class, 'create']);
Route::put('pembayaran/{id}', [PembayaranController::class, 'update']);



Route::middleware(['auth'])->group(function () {
    Route::get('/pembayaran_kelas', [PembayaranKelasController::class, 'index'])->name('pembayaran_kelas.index');
    Route::post('/pembayaran_kelas', [PembayaranKelasController::class, 'store'])->name('pembayaran_kelas.store');
    Route::get('/pembayaran_kelas/create', [PembayaranKelasController::class, 'create'])->name('pembayaran_kelas.create');
    Route::get('/pembayaran_kelas/{id}', [PembayaranKelasController::class, 'show'])->name('pembayaran_kelas.show');
});




Route::middleware(['auth'])->group(function () {
    Route::get('/pembayaran_siswa', [PembayaranSiswaController::class, 'index'])->name('pembayaran_siswa.index');
    Route::post('/pembayaran_siswa', [PembayaranSiswaController::class, 'store'])->name('pembayaran_siswa.store');
    Route::get('/pembayaran_siswa/create', [PembayaranSiswaController::class, 'create'])->name('pembayaran_siswa.create');
    Route::get('/pembayaran_siswa/{id}', [PembayaranSiswaController::class, 'show'])->name('pembayaran_siswa.show');
});


Route::get('/petugas', [PetugasController::class, 'index']);
Route::post('/petugas', [PetugasController::class, 'store']);
Route::put('/petugas/{id}', [PetugasController::class, 'update']);
Route::delete('/petugas/{id}', [PetugasController::class, 'destroy']);



Route::middleware(['auth:api'])->group(function () {
    Route::get('/siswa_kelas', [SiswakelasController::class, 'index'])->name('siswa_kelas.index');
    Route::post('/siswa_kelas', [SiswakelasController::class, 'store'])->name('siswa_kelas.store');
    Route::get('/siswa_kelas/{id}/edit', [SiswakelasController::class, 'edit'])->name('siswa_kelas.edit');
    Route::put('/siswa_kelas/{id}', [SiswakelasController::class, 'update'])->name('siswa_kelas.update');
    Route::delete('/siswa_kelas/{id}', [SiswakelasController::class, 'destroy'])->name('siswa_kelas.destroy');
});


Route::get('/spp', [SppController::class, 'index']);
Route::post('/spp', [SppController::class, 'store']);
Route::put('/spp/{id}', [SppController::class, 'update']);
Route::delete('/spp/{id}', [SppController::class, 'destroy']);

Route::get('/siswa', [SiswaController::class, 'index']);
Route::post('/siswa', [SiswaController::class, 'store']);
Route::put('/siswa/{id}', [SiswaController::class, 'update']);
Route::delete('/siswa/{id}', [SiswaController::class, 'destroy']);