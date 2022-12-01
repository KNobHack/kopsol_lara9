<?php

use App\Http\Controllers\Anggota;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Simpanan;
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
	Route::get('/profile/edit', [Profile::class, 'edit'])->name('profile.edit');
	Route::put('/profile', [Profile::class, 'update']);

	Route::middleware('complete.profile')->group(function () {
		Route::get('/', function () {
			return redirect('/dashboard');
		});

		Route::get('/dashboard', [Dashboard::class, 'index']);

		// profil dirinya sendiri
		Route::get('/profile', [Profile::class, 'show'])->name('profile');

		Route::get('/profile/{user}', [Profile::class, 'show'])->name('profile.detail');
		Route::put('/profile/{user}/edit', [Profile::class, 'update']);

		Route::resource('anggota', Anggota::class);

		Route::resource('simpanan', Simpanan::class);
	});
});
