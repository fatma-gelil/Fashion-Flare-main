<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\User\UserImgController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::get('imgs/delete/{id}',[UserImgController::class,'destroy']);
//Route::get('imgs/store',[UserImgController::class,'upload']);
//Route::get('/products/{id}', [ProductController::class, 'showId'])->name('products.showId');
Route::get('/category/{category}',[\App\Http\Controllers\API\CategoryController::class,'show'])->name('category.show');
