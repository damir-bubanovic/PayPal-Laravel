<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PayPalController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('/paypal', PayPalController::class);
Route::post('handle-payment', [PayPalController::class, 'handlePayment'])->name('make.payment');
Route::get('cancel-payment', [PayPalController::class, 'cancelPayment'])->name('cancel.payment');
Route::get('payment-success', [PayPalController::class, 'paymentSuccess'])->name('success.payment');

require __DIR__.'/auth.php';
