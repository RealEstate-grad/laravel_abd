<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registercontroller;
use App\Http\Controllers\logincontroller ;
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
Route::get('register', [Registercontroller::class,'index'])->name('userregister');
Route::post('/register', [Registercontroller ::class,'register']);
Route::get('login', [ logincontroller::class,'index'])->name('loginuser');
Route::post('/login', [ logincontroller::class,'login']);
 
Route::get('/', function () {
  return view('register');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
