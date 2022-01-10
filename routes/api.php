<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);

Route::prefix('user')->middleware(['auth:sanctum'])->group(function (){
    Route::match(['POST','GET'],'profile', [\App\Http\Controllers\Api\UserController::class,'index']);
    Route::post('profile/avatar', [\App\Http\Controllers\Api\UserController::class,'avatar']);

    Route::get('pelabuhan',[\App\Http\Controllers\Api\KapalController::class, 'pelabuhan']);
    Route::get('kapal',[\App\Http\Controllers\Api\KapalController::class, 'index']);
    Route::get('kapal/{id}',[\App\Http\Controllers\Api\KapalController::class, 'show']);

    Route::match(['POST','GET'],'pesanan', [\App\Http\Controllers\Api\TransaksiController::class, 'index']);
    Route::get('pesanan/delete/{id}', [\App\Http\Controllers\Api\TransaksiController::class, 'delete']);
    Route::get('pesanan/checkout', [\App\Http\Controllers\Api\TransaksiController::class, 'checkout']);
    Route::get('pembayaran', [\App\Http\Controllers\Api\TransaksiController::class, 'pembayaran']);
    Route::match(['POST','GET'],'pembayaran/{id}', [\App\Http\Controllers\Api\TransaksiController::class, 'pembayaranDetail']);
});

Route::prefix('agen')->middleware(['auth:sanctum'])->group(function (){
    Route::get('scan-qr', [\App\Http\Controllers\Api\ChekinController::class, 'scanQr']);
    Route::get('kapal',[\App\Http\Controllers\Api\ChekinController::class,'dataKapal']);
    Route::get('penumpang/{idJadwal}',[\App\Http\Controllers\Api\ChekinController::class,'dataPenumpang']);


});
