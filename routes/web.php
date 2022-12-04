<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\TransaksiController;
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

Route::middleware('auth')->group(function () {

	// Harus isi dulu profil
	Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::put('/profile', [ProfileController::class, 'update']);

	Route::middleware('complete.profile')->group(function () {
		Route::get('/', function () {
			return redirect('/dashboard');
		});

		Route::get('/profile/{anggota}', [ProfileController::class, 'showSpecific'])->name('profile.specific');
		Route::get('/profile/{anggota}/edit', [ProfileController::class, 'editSpecific'])->name('profile.edit.specific');
		Route::put('/profile/{anggota}', [ProfileController::class, 'updateSpecific']);

		Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

		// profil dirinya sendiri
		Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

		Route::resource('anggota', AnggotaController::class);

		Route::resource('produk', ProdukController::class);

		Route::resource('simpanan', SimpananController::class);
		Route::get('/simpanan-pokok', [SimpananController::class, 'simpananPokok'])->name('simpanan.pokok');
		Route::get('/simpanan-wajib', [SimpananController::class, 'simpananWajib'])->name('simpanan.wajib');
		Route::get('/simpanan-sukarela', [SimpananController::class, 'simpananSukarela'])->name('simpanan.sukarela');

		Route::resource('transaksi', TransaksiController::class);
		Route::get('/transaksi/create/anggota/{anggota}', [TransaksiController::class, 'createAnggota'])->name('transaksi.create.for.anggota');
		Route::get('/transaksi/create/non-anggota/{nonanggota}', [TransaksiController::class, 'createNonAnggota'])->name('transaksi.create.for.nonanggota');
	});
});
