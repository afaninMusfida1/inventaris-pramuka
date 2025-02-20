<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanUserController;
use App\Http\Controllers\ProfileController;
use App\Models\Barang;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $barang = Barang::all(); // Ambil semua data barang dari database
    return view('dashboard', compact('barang')); // Kirim data ke view
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute Peminjaman
Route::middleware('auth')->group(function () {
    Route::get('/peminjaman', [PeminjamanUserController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanUserController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanUserController::class, 'store'])->name('peminjaman.store');
});

require __DIR__.'/auth.php';
