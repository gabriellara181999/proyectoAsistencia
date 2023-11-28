<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UsuarioApiController;
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

Route::group(['prefix'=>'version1'], function(){
    Route::post('/login', [UsuarioApiController::class, 'login']);
    Route::post('/qrDatos', [UsuarioApiController::class, 'recibirDatosQr'])->name('recibirDatosQr');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UsuarioApiController::class, 'logout']);
        Route::post('/listadoMateria', [UsuarioApiController::class, 'listadoMaterias']);
    });
});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}) */;
