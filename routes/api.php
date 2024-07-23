<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\realestateFormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\Api\realestateController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\SearchController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//User Auth
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::get('/user-details', [PassportAuthController::class, 'getUserDetails']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [PassportAuthController::class, 'logout']);
});

//Admin Auth
Route::post('AdminRegister', [PassportAuthController::class, 'AdminRegister']);
Route::post('AdminLogin', [PassportAuthController::class, 'AdminLogin']);
//add-realestate
Route::post('/add-realestate', [AdminController::class, 'addrealestate']);
//delete realestate
Route::Delete('/delete/{id}', [AdminController::class, 'delete']);
//edit-realestate
Route::put('/edit-product/{id}', [AdminController::class, 'updaterealestate']);
//display realestate
Route::get('/products', [realestateController::class, 'index']);
//display realestate details
Route::get('/products/{id}', [realestateController::class, 'show']);
//Form Submisstion
Route::post('/Form', [realestateFormController::class,'processForm']);
//Return Recommendations
Route::get('/recommendations', [RecommendationController::class,'recommendations']);
//search 
Route::get('/search', [SearchController::class, 'search']);
//filters
Route::get('/filter', [SearchController::class, 'getFilters']);
Route::post('/filterSubmit', [SearchController::class, 'handleCheckboxSubmission']);
Route::get('/filterResults', [SearchController::class, 'getFilteredrealestates']);
//Review realestate
Route::post('/Review/{productId}/{rating}', [realestateController::class, 'Review']);
