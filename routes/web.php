<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BillController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Laluan test awal (Boleh simpan buat kenangan/backup)
Route::get('/test-imap', function () {
    try {
        // Cuba berhubung dengan Gmail
        $client = \Webklex\IMAP\Facades\Client::account('default');
        $client->connect();
        
        return "The system successfully broke into Gmail. The door is wide open!";
    } catch (\Exception $e) {
        return "Oh no, failed:" . $e->getMessage();
    }
});

// Laluan untuk tarik bil dari Gmail
Route::get('/baca-emel', [BillController::class, 'ekstrakDanSimpan']);

// ---> LALUAN BARU UNTUK MONITORED BILLERS KITA TAMBAH KAT SINI <---
Route::get('/monitored-billers', [DashboardController::class, 'monitoredBillers'])
    ->middleware(['auth', 'verified'])
    ->name('monitored-billers');

    // LALUAN UNTUK ADMIN PORTAL
Route::get('/admin-portal', [App\Http\Controllers\DashboardController::class, 'adminPortal'])
    ->middleware(['auth', 'verified'])
    ->name('admin-portal');