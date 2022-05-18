<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentReactController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/book/create', [BookController::class, 'create'])->name('BookCreate');
    Route::get('/book/update/{id}', [BookController::class, 'bookData'])->name('BookUpdate');
    Route::post('/book/delete', [BookController::class, 'delete'])->name('BookDelete');
    Route::post('/book/upload', [BookController::class, 'upload'])->name('Upload');
    Route::get('/book/download', [BookController::class, 'download'])->name('Download');
    Route::post('/cart', [CartController::class, 'getCartDataByBook'])->name('CartDataByBook');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cartStore');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cartUpdate');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeCart'])->name('cartRemove');
    Route::post('/cart/{user_id}', [CartController::class, 'cartList'])->name('cartList');
    Route::post('/clear', [CartController::class, 'clearAllCart'])->name('cartClear');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkoutItem');
    Route::post('/order', [OrderController::class, 'OrderByUser'])->name('Order');
    Route::post('/order/list', [OrderController::class, 'getOrderList'])->name('OrderList');
});

Route::get('/user/list', [UserController::class, 'list'])->name('UserList');
Route::post('/user/create', [UserController::class, 'create'])->name('UserCreate');
Route::post('/book/list', [BookController::class, 'list'])->name('BookList');
Route::get('/book/detail/{id}', [BookController::class, 'bookData'])->name('Detail');
Route::post('/comment/list', [CommentReactController::class, 'list'])->name('CommentList');
Route::post('/comment/create', [CommentReactController::class, 'addComment'])->name('AddComment');
