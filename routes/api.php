<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::middleware('api-log')->post('/login', function (Request $request) {
    return ['code' => 200,'msg' => 'success','data' => ['userId'=> '1', 'token'=> 'debug',]];
});*/
Route::middleware(['api-log'])->group(function(){
    Route::post('/login',[\App\Http\Controllers\Api\LoginController::class,'post']);
    Route::get('/menu',[\App\Http\Controllers\Api\BaseController::class,'menu']);
    Route::post('/material',[\App\Http\Controllers\Api\MaterialController::class,'index']);
    Route::delete('/material/{id}',[\App\Http\Controllers\Api\MaterialController::class,'delete']);
    Route::post('/material/create-or-update',[\App\Http\Controllers\Api\MaterialController::class,'createOrUpdate']);
    Route::post('/sku',[\App\Http\Controllers\Api\SkuController::class,'index']);
    Route::post('/sku/create',[\App\Http\Controllers\Api\SkuController::class,'create']);
    Route::delete('/sku/{id}',[\App\Http\Controllers\Api\SkuController::class,'delete']);
});

