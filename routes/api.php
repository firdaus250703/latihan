<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiKategori;
use App\Http\Controllers\API\ApiBuku;

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

Route::get('/family', [ApiKategori::class, 'getData']);
Route::post('/family/store', [ApiKategori::class, 'store']);
Route::get('/family/show/{id}', [ApiKategori::class, 'show']);
Route::get('/family/destroy/{id}', [ApiKategori::class, 'destroy']);
Route::post('/family/update/{id}', [ApiKategori::class, 'update']);


Route::get('/buku', [ApiBuku::class, 'getData']);
Route::post('/buku/store', [ApiBuku::class, 'store']);
Route::get('/buku/show/{id}', [ApiBuku::class, 'show']);
Route::get('/buku/destroy/{id}', [ApiBuku::class, 'destroy']);
Route::post('/buku/update/{id}', [ApiBuku::class, 'update']);
