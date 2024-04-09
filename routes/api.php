<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostXuxe;
use App\Http\Controllers\PostUser;
use App\Http\Controllers\PostInvXuxe;
use App\Http\Controllers\PostInventario;
use App\Http\Controllers\AuthController;


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
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('User/', [PostUser::class, 'index'])->name('uindex');
Route::get('User/show/{id}', [PostUser::class, 'show'])->name('ushow');
Route::post('User/store', [PostUser::class, 'store'])->name('ustore');
Route::post('User/update/{id}', [PostUser::class, 'update'])->name('uupdate');
Route::delete('User/delete/{id}', [PostUser::class, 'destroy'])->name('udestroy');

//Xuxemons
Route::get('Xuxemon/load', [PostXuxe::class, 'cargarXuxemon'])->name('xload');
Route::get('Xuxemon/', [PostXuxe::class, 'index'])->name('xindex');
Route::get('Xuxemon/show/{id}', [PostXuxe::class, 'show'])->name('xshow');
Route::post('Xuxemon/store', [PostXuxe::class, 'store'])->name('xstore');
Route::post('Xuxemon/update/{id}', [PostXuxe::class, 'update'])->name('xupdate');
Route::delete('Xuxemon/delete/{id}', [PostXuxe::class, 'destroy'])->name('xdestroy');
Route::post('Xuxemon/actualizar-tamano', [PostXuxe::class, 'actualizartamano'])->name('xactualizartamano');



//Inventario Xuxemons
Route::post('Xuxemon/give', [PostInvXuxe::class, 'give'])->name('xgive');
Route::get('Xuxemon/mostrar/{id}', [PostInvXuxe::class, 'mostrar'])->name('mostrar');

//Inventario Items
Route::get('Inventario/{userId}', [PostInventario::class, 'show'])->name('mostrarinv');


//Route::post('Inventario/{userId}/update', [PostInventario::class, 'updateInventario'])->name('updateobjeto');
