<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

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

Route::put('books/restore/{id}', [BookController::class, 'restore'])->name('books.restore');
Route::get('books/trashed', [BookController::class, 'showTrashed'])->name('books.trashed');
Route::delete('books/forceDelete/{id}', [BookController::class, 'forceDelete'])->name('books.forceDelete');
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::put('categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
Route::get('categories/trashed', [CategoryController::class, 'showTrashed'])->name('categories.trashed');
Route::delete('categories/forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
Route::get('categories/{id}/books', [CategoryController::class, 'indexByCategory'])->name('categories.trashed');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::apiResource('books', BookController::class);
Route::apiResource('categories', CategoryController::class);

