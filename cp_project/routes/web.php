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

//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/add_field', [App\Http\Controllers\HomeController::class, 'add_field'])
Route::post('add_field','App\Http\Controllers\HomeController@add_field')->name('add_field');
Route::get('delete_field/{id}','App\Http\Controllers\HomeController@delete_field')->name('delete_field');
