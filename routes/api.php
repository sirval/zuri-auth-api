<?php

use App\Http\Controllers\Api\v1\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function()
{
    Route::group(['middleware'=>['auth:sanctum']], function(){
        Route::get('/users', [UserController::class, 'GetUsers'])->name('user.users');
        Route::get('/user/{id}', [UserController::class, 'GetUser'])->name('user.user');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    });    
        //public routes
    Route::post('/user/create', [UserController::class, 'register'])->name('user.register');
    Route::post('/user/login', [UserController::class, 'login'])->name('user.login');
});
// "token": "1|V8f4Uz0ZdGEkcmIbJbddIu1Y6fXKry2d01V2Voe9"