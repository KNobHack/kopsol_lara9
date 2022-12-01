<?php

use App\Http\Controllers\Anggota;
use App\Http\Controllers\Dashboard;
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

Route::get('/', function () {
	return redirect('/dashboard');
});

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware('auth');;

Route::resource('anggota', Anggota::class);
Route::resource('simpanan', Simpanan::class);
