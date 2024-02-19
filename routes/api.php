<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostXuxe;


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

Route::get('/', [PostXuxe::class, 'index'])->name('index');
Route::get('/show/{id}', [PostXuxe::class, 'show'])->name('show');
Route::post('/store', [PostXuxe::class, 'store'])->name('store');
Route::post('/update/{id}', [PostXuxe::class, 'update'])->name('update');
Route::delete('/delete/{id}', [PostXuxe::class, 'destroy'])->name('destroy');
