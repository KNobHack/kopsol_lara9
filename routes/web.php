<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\NonAnggotaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\TransaksiController;
use App\Models\Transaksi;
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

		Route::resource('non-anggota', NonAnggotaController::class)
			->parameter('non-anggota', 'non_anggota');

		Route::resource('produk', ProdukController::class);

		Route::resource('simpanan', SimpananController::class);
		Route::get('/simpanan-pokok', [SimpananController::class, 'simpananPokok'])->name('simpanan.pokok');
		Route::get('/simpanan-wajib', [SimpananController::class, 'simpananWajib'])->name('simpanan.wajib');
		Route::get('/simpanan-sukarela', [SimpananController::class, 'simpananSukarela'])->name('simpanan.sukarela');

		// Transaksi Start
		Route::resource('transaksi', TransaksiController::class)->except('store');

		// Transaksi create
		Route::get('/transaksi/create/anggota/{anggota}', [TransaksiController::class, 'createAnggota'])
			->name('transaksi.create.for.anggota');
		Route::get('/transaksi/create/non-anggota/{nonanggota}', [TransaksiController::class, 'createNonAnggota'])
			->name('transaksi.create.for.nonanggota');

		// Transaksi store as draft in session
		Route::post('/transaksi/create/anggota/{anggota}/add/produk', [TransaksiController::class, 'anggotaAddFromProduk'])
			->name('transaksi.add.from.produk.for.anggota');
		Route::post('/transaksi/create/anggota/{anggota}/add/tungakan/{tunggakan}', [TransaksiController::class, 'anggotaAddFromTunggakan'])
			->name('transaksi.add.from.tunggakan.for.anggota');

		// Transaksi remove draft
		Route::delete('/transaksi/create/anggota/{anggota}/remove/{index}', [TransaksiController::class, 'anggotaRemove'])
			->name('transaksi.remove.for.anggota')
			->where('id', '[0-9]+');

		// Transaksi store to database
		Route::post('/transaksi/lunas/anggota/{anggota}', [TransaksiController::class, 'lunasAnggota'])
			->name('transaksi.lunas.for.anngota');
		Route::post('/transaksi/utang/anggota/{anggota}', [TransaksiController::class, 'utangAnggota'])
			->name('transaksi.utang.for.anggota');

		// Transaksi End
	});
});
