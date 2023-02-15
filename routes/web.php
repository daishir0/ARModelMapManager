<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ArController;
use App\Http\Controllers\MapController;

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

Route::controller(ArController::class)->group(function() {

    Route::get('/ar', 'index');

});


Route::controller(MapController::class)->group(function() {

    Route::get('/map', 'index');

});


Route::controller(FileController::class)->group(function() {

    Route::get('/upload', 'upload')->name('file.upload');
    Route::post('/store', 'store')->name('file.store');
    Route::get('/upload/{id}', 'extract')->name('file.extract');
    Route::get('/download', 'download')->name('file.download');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
