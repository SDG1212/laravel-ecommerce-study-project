<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\View\Components\Newsletter;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/subscribe', [Newsletter::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('cart')->controller(CartController::class)->group(function() {
    Route::post('/add', 'addProduct');
    Route::post('/edit', 'editProduct');
    Route::post('/delete', 'deleteProduct');
    Route::get('/info', 'getInfo');
});

require __DIR__.'/auth.php';
