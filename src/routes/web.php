<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index'])->name('top');
Route::get('/sell', [ItemController::class, 'exhibition'])->name('sell');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/mypage', [ProfileController::class, 'profile'])->name('mypage');
Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('mypage.profile');
Route::get('/item/{item_id}', [ItemController::class, 'detail']);
Route::middleware('auth')->get('/purchase/{item}', [PurchaseController::class, 'purchase'])->name('purchase');

Route::middleware('auth')->get('/purchase/address', [PurchaseController::class, 'address'])->name('address.edit');
Route::middleware('auth')->post('/address/update', [PurchaseController::class, 'updateAddress'])->name('address.update');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//     ->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('like.toggle');
});


