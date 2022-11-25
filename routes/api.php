<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', [UserController::class,'index']);
Route::get('/user/{id_user}/car', [UserController::class,'getcar']);
Route::get('/user/{id_user}/removecar', [UserController::class,'removecar']);
Route::get('/car/{id_car}', [CarController::class,'show']);
Route::get('/car/{id_car}/user', [CarController::class,'getuser']);
Route::get('/car', [CarController::class,'index']);
Route::post('/login', [UserController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']],  function (){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/car', [CarController::class,'store']);
    Route::delete('/car/{id}', [CarController::class,'destroy']);
    Route::put('/car/{id}', [CarController::class,'update']);
    Route::post('/user', [UserController::class,'store']);
    Route::get('/user/{id_user}/car/{id_car}', [UserController::class,'addcar']);
});
