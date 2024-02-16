<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DataLaporanController;
use App\Http\Controllers\Backend\laporan;
use App\Http\Controllers\Backend\MasterBarangController;
use App\Http\Controllers\Backend\MasterDataController;
use App\Http\Controllers\Backend\ReturnPenjualanController;
use App\Http\Controllers\Backend\TransaksiPembelianController;
use App\Http\Controllers\Backend\TransaksiPenerimaanController;
use App\Http\Controllers\Backend\TransaksiPengeluaranController;
use App\Http\Controllers\Backend\TransaksiPenjualanController;
use App\Models\TransaksiPembelian;
use App\Models\TransaksiPengeluaran;
use App\Models\TransaksiPenjualan;
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
    return view('auth.login');
});

Route::group(['middleware' => ['role:admin,pimpinan,pengawas-lapangan', 'auth']], function () {

    // DASHBOARD USER
    Route::get('/dashboard', MasterDataController::class . '@index')->name('dashboard.index');

    // MASTER USER
    Route::get('/user', MasterDataController::class . '@userIndex')->name('user.index');
    Route::post('/userStore', MasterDataController::class . '@userStore')->name('user.store');
    Route::post('/userEdit', MasterDataController::class . '@userEdit')->name('user.edit');
    Route::post('/userDestroy', MasterDataController::class . '@userDestroy')->name('user.destroy');

    // MASTER USER
    Route::get('/alat', MasterDataController::class . '@alatIndex')->name('alat.index');
    Route::post('/alatStore', MasterDataController::class . '@alatStore')->name('alat.store');
    Route::post('/alatEdit', MasterDataController::class . '@alatEdit')->name('alat.edit');
    Route::post('/alatDestroy', MasterDataController::class . '@alatDestroy')->name('alat.destroy');

    Route::get('/cekRelasi', function () {
        $pengeluarans   =   TransaksiPengeluaran::with(['pengeluarandetail', 'supplier'])->latest()->get();

        return $pengeluarans;
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
