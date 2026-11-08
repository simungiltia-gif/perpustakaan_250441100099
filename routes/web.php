<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    // Dashboard siswa
    return view('dashboard');

})->middleware('auth')->name('dashboard');


Route::middleware(['auth'])->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.index');


    // Pengelolaan buku (tambah, ubah, hapus).
    // Harus didaftarkan SEBELUM /buku/{id} agar /buku/create tidak tertangkap oleh {id}.
    Route::middleware(['can:kelola-buku'])->group(function () {

        Route::get('/buku/create', [BukuController::class, 'create'])
            ->name('buku.create');

        Route::post('/buku', [BukuController::class, 'store'])
            ->name('buku.store');

        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])
            ->whereNumber('buku')
            ->name('buku.edit');

        Route::put('/buku/{buku}', [BukuController::class, 'update'])
            ->whereNumber('buku')
            ->name('buku.update');

        // SOAL 2(c): hapus memakai method DELETE (dilindungi token CSRF).
        // Route GET /buku/{buku}/hapus sudah dihapus.
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
            ->whereNumber('buku')
            ->name('buku.destroy');

    });


    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->whereNumber('id')
        ->middleware('permission:lihat daftar buku')
        ->name('buku.show');


    // SOAL 2(b): pencarian judul (query sudah memakai binding di controller)
    Route::get('/buku-cari', [BukuController::class, 'cari'])
        ->name('buku.cari');


    Route::post('/peminjaman/ajukan', [PeminjamanController::class, 'ajukan'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman.ajukan');


    // A4 masih rentan sampai Soal 4 (hanya middleware auth)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
        ->whereNumber('id')
        ->name('peminjaman.show');


    Route::get('/riwayat-pribadi', [PeminjamanController::class, 'riwayatSaya'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')
        ->name('peminjaman.saya');


    Route::middleware(['permission:akses dashboard admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        Route::resource('/users', UserController::class);

    });


    Route::middleware(['permission:akses dashboard petugas'])->group(function () {

        Route::get('/petugas/dashboard', [PetugasController::class, 'index'])
            ->name('petugas.dashboard');

    });


    Route::middleware(['permission:kelola peminjaman'])->group(function () {

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('peminjaman.index');

        Route::post('/peminjaman/proses/{id}', [PeminjamanController::class, 'proses'])
            ->name('peminjaman.proses');

        Route::post('/pengembalian/proses/{id}', [PeminjamanController::class, 'kembali'])
            ->name('pengembalian.proses');

    });


    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')
        ->name('laporan.index');

});


require __DIR__.'/auth.php';