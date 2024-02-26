<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostXuxe;
use App\Http\Controllers\PostUser;


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


//User
Route::get('User/', [PostUser::class, 'index'])->name('index');
Route::get('User/show/{id}', [PostUser::class, 'show'])->name('show');
Route::post('User/store', [PostUser::class, 'store'])->name('store');
Route::post('User/update/{id}', [PostUser::class, 'update'])->name('update');
Route::delete('User/delete/{id}', [PostUser::class, 'destroy'])->name('destroy');

//Xuxemons
Route::get('Xuxemon/', [PostXuxe::class, 'index'])->name('index');
Route::get('Xuxemon/show/{id}', [PostXuxe::class, 'show'])->name('show');
Route::post('Xuxemon/store', [PostXuxe::class, 'store'])->name('store');
Route::post('Xuxemon/update/{id}', [PostXuxe::class, 'update'])->name('update');
Route::delete('Xuxemon/delete/{id}', [PostXuxe::class, 'destroy'])->name('destroy');
