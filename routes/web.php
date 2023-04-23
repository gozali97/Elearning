<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminJadwalPelajaranController;
use App\Http\Controllers\Admin\AdminJurusanController;
use App\Http\Controllers\Admin\AdminKelasController as AdminAdminKelasController;
use App\Http\Controllers\Admin\AdminMataPelajaranController;
use App\Http\Controllers\Admin\ManageGuruController;
use App\Http\Controllers\AdminKelasController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Siswa\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::controller(ManageGuruController::class)->group(function () {
        Route::get('/manageGuru', 'index')->name('manageGuru.index');
        Route::post('/manageGuru/store', 'store')->name('manageGuru.store');
        Route::post('/manageGuru/update/{id}', 'update')->name('manageGuru.update');
    });

    Route::controller(AdminAdminKelasController::class)->group(function () {
        Route::get('/kelas', 'index')->name('admin.kelas.index');
        Route::get('/kelas/create', 'create')->name('admin.kelas.create');
        Route::post('/kelas/store', 'store')->name('admin.kelas.store');
        Route::get('/kelas/edit/{id}', 'edit')->name('admin.kelas.edit');
        Route::post('/kelas/update/{id}', 'update')->name('admin.kelas.update');
        Route::get('/kelas/destroy/{id}', 'destroy')->name('admin.kelas.destroy');
    });

    Route::controller(AdminJurusanController::class)->group(function () {
        Route::get('/jurusan', 'index')->name('admin.jurusan.index');
        Route::get('/jurusan/create', 'create')->name('admin.jurusan.create');
        Route::post('/jurusan/store', 'store')->name('admin.jurusan.store');
        Route::get('/jurusan/edit/{id}', 'edit')->name('admin.jurusan.edit');
        Route::post('/jurusan/update/{id}', 'update')->name('admin.jurusan.update');
        Route::get('/jurusan/destroy/{id}', 'destroy')->name('admin.jurusan.destroy');
    });

    Route::controller(AdminMataPelajaranController::class)->group(function () {
        Route::get('/mapel', 'index')->name('admin.mapel.index');
        Route::get('/mapel/create', 'create')->name('admin.mapel.create');
        Route::post('/mapel/store', 'store')->name('admin.mapel.store');
        Route::get('/mapel/edit/{id}', 'edit')->name('admin.mapel.edit');
        Route::post('/mapel/update/{id}', 'update')->name('admin.mapel.update');
        Route::get('/mapel/destroy/{id}', 'destroy')->name('admin.mapel.destroy');
    });

    Route::controller(AdminJadwalPelajaranController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('admin.jadwal.index');
        Route::get('/jadwal/create', 'create')->name('admin.jadwal.create');
        Route::post('/jadwal/store', 'store')->name('admin.jadwal.store');
        Route::get('/jadwal/edit/{id}', 'edit')->name('admin.jadwal.edit');
        Route::post('/jadwal/update/{id}', 'update')->name('admin.jadwal.update');
        Route::get('/jadwal/destroy/{id}', 'destroy')->name('admin.jadwal.destroy');
    });

});


Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru', [GuruController::class, 'index'])->name('guru');

});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
});
