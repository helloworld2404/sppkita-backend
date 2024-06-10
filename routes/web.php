<?php

use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembayaranKelasController;
use App\Http\Controllers\PembayaranSiswaController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswakelasController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>false]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::middleware('auth')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('kelas',KelasController::class);
    Route::resource('spp',SppController::class);
    Route::resource('siswa',SiswaController::class);
    Route::resource('siswa_kelas',SiswakelasController::class);
    Route::resource('pembayaran',PembayaranController::class);
    Route::resource('pembayaran_kelas',PembayaranKelasController::class);
    Route::resource('pembayaran_siswa',PembayaranSiswaController::class);
    Route::resource('petugas',PetugasController::class);
    Route::resource('guru',GuruController::class);

    

Route::get('petugas', [PetugasController::class, 'index'])->name('petugas.index');
Route::post('petugas', [PetugasController::class, 'store'])->name('petugas.store');
Route::put('petugas/{id}', [PetugasController::class, 'update'])->name('petugas.update');
Route::delete('petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');


    
});
