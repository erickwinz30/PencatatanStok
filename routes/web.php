<?php

use App\Http\Controllers\ControllerBarang;
use App\Http\Controllers\ControllerLog;
use App\Http\Controllers\ControllerLogin;
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
    return view('welcome');
});

Route::get('viewBarang', [ControllerBarang::class, 'readBarang'])->middleware('checkRole:gudang');
Route::get('viewBarang/tambahBaru', [ControllerBarang::class, 'insertBarangBaru'])->middleware('checkRole:gudang');
Route::post('viewBarang/tambahBaru/simpan', [ControllerBarang::class, 'tambahBaru'])->middleware('checkRole:gudang');

//edit
Route::get('viewBarang/barangMasuk/{id_barang}', [ControllerBarang::class, 'editBarangMasuk'])->middleware('checkRole:gudang');
Route::post('viewBarang/barangMasuk/edit', [ControllerBarang::class, 'updateBarangMasuk'])->middleware('checkRole:gudang');
Route::get('viewBarang/barangKeluar/{id_barang}', [ControllerBarang::class, 'editBarangKeluar'])->middleware('checkRole:gudang');
Route::post('viewBarang/barangKeluar/edit', [ControllerBarang::class, 'updateBarangKeluar'])->middleware('checkRole:gudang');

//Log
Route::get('viewLogMasuk', [ControllerLog::class, 'logBarangMasuk'])->middleware('checkRole:gudang');
Route::get('viewLogKeluar', [ControllerLog::class, 'logBarangKeluar'])->middleware('checkRole:gudang');

//login
Route::get('login',[ControllerLogin::class, 'login']);
Route::post('actionlogin',[ControllerLogin::class, 'actionlogin']);

//registrasi
Route::get('registrasi',[ControllerLogin::class,'registrasi']);
Route::post('postregistrasi',[ControllerLogin::class,'postregistrasi']);