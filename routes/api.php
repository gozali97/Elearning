<?php

use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MataPelajaranController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SiswaTugasController;
use App\Http\Controllers\Api\DiskusiController;

use App\Models\Role;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::post('/profil', [ProfileController::class, 'index']);
Route::post('/kelas', [KelasController::class, 'index']);
Route::post('/mapel', [MataPelajaranController::class, 'index']);

Route::controller(SiswaTugasController::class)->group(function () {
    Route::post('/siswa/listPelajaran', 'index')->name('siswa.lisPelajaran');
    Route::post('/siswa/viewMateri', 'viewMateri')->name('siswa.viewMateri');

    Route::post('/siswa/viewTugas', 'viewTugas')->name('siswa.viewTugas');
    Route::post('/siswa/uploadTugas', 'store')->name('siswa.uploadTugas');
    Route::post('/siswa/updateTugas', 'update')->name('siswa.updateTugas');
});

Route::controller(DiskusiController::class)->group(function () {
    Route::post('/materi/diskusi', 'index')->name('materi.diskusi');
    Route::post('/materi/addDiskusi', 'store')->name('materi.addDiskusi');
});