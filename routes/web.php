<?php

use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\AuthController;
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

// User Authentication
Route::get('/login',[AuthController::class,'showLogin']);
Route::post('/login',[AuthController::class,'authenticateAdmnin']);
Route::get('/logout',[AuthController::class,'logout']);
Route::get('/reset/password',[AuthController::class,'showResetPassword']);
Route::post('/reset/password',[AuthController::class,'resetPassword']);
Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/register',[AuthController::class,'postRegister']);


Route::group(['middleware'=>'AuthUser'],function(){
    Route::get('/task',[TaskController::class,'index']);
    Route::get('/create',[TaskController::class,'create']);
    Route::post('/task/create',[TaskController::class,'store']);
    Route::post('/task/delete',[TaskController::class,'destroy']);
    Route::get('/task/{id}/edit',[TaskController::class,'edit']);
    Route::put('/task/{id}',[TaskController::class,'update']);
    Route::post('/task/complete',[TaskController::class,'makeComplete']);
    Route::get('/task/search/{search}',[TaskController::class,'searchTask']);
});
