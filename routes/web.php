<?php

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

Route::get('/', [App\Http\Controllers\Controller::class, 'movies'])->name('movies');
Route::get('/series', [App\Http\Controllers\Controller::class, 'series'])->name('series');

Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->middleware('auth');
Route::post('/favorites', [App\Http\Controllers\FavoriteController::class, 'create'])->middleware('auth');
Route::post('/favorites/delete', [App\Http\Controllers\FavoriteController::class, 'delete'])->middleware('auth');

Route::get('/search', [App\Http\Controllers\Controller::class, 'search']);

Auth::routes();
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
