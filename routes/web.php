<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Kumpulan laluan untuk Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Laluan test awal (Boleh simpan buat kenangan/backup)
Route::get('/test-imap', function () {
    try {
        $client = \Webklex\IMAP\Facades\Client::account('default');
        $client->connect();
        return "The system successfully broke into Gmail. The door is wide open!";
    } catch (\Exception $e) {
        return "Oh no, failed:" . $e->getMessage();
    }
});

// Laluan untuk tarik bil dari Gmail (Sync)
Route::get('/baca-emel', [BillController::class, 'ekstrakDanSimpan'])
    ->middleware('auth'); // Wajib login untuk tekan sync


// ==============================================================
// KUMPULAN LALUAN SELAMAT (Wajib Login & Verified)
// ==============================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- 1. LALUAN UNTUK MONITORED BILLERS (CRUD) ---
    // Papar senarai Biller
    Route::get('/monitored-billers', [BillerController::class, 'index'])->name('monitored-billers');
    // Tambah Biller Baru
    Route::post('/billers', [BillerController::class, 'store']);
    // Padam Biller
    Route::delete('/billers/{id}', [BillerController::class, 'destroy']);

    // --- 2. LALUAN UNTUK ADMIN PORTAL ---
    Route::get('/admin-portal', [DashboardController::class, 'adminPortal'])->name('admin-portal');

});