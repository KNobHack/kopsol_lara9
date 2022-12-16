<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Central\DashboardController;
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
	});
});
