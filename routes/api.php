<?php

use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SiswaTugasController;
use App\Http\Controllers\Api\DiskusiController;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/notif', [NotifikasiController::class, 'setNotifikasiByDevice']); //cek

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::prefix('/profile')->group(function () {
            Route::post('/', 'index')->name('profil');
            Route::post('/updateProfile', 'updateProfile')->name('profil.updateProfile');
            Route::post('/updatePassword', 'updatePassword')->name('profil.updatePassword');
        });
    });

    Route::controller(SiswaTugasController::class)->group(function () {
        Route::prefix('/siswa')->group(function () {
            Route::post('/listPelajaran', 'index')->name('siswa.lisPelajaran');
            Route::post('/viewMateri', 'viewMateri')->name('siswa.viewMateri');
    
            Route::post('/viewTugas', 'viewTugas')->name('siswa.viewTugas');
            Route::post('/uploadTugas', 'store')->name('siswa.uploadTugas');
            Route::post('/updateTugas', 'update')->name('siswa.updateTugas');
        });
    });

    Route::controller(DiskusiController::class)->group(function () {
        Route::prefix('/materi')->group(function () {
            Route::post('/diskusi', 'index')->name('materi.diskusi');
            Route::post('/addDiskusi', 'store')->name('materi.addDiskusi');
        });
    });

    Route::post('/logout', [LoginController::class, 'logout']);
});