<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PaymentController;



Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/about', [AboutController::class, 'about'])->name('about');

Route::get('/service', [ServiceController::class, 'service'])->name('service');
Route::get('/team', [TeamController::class, 'team'])->name('team');
Route::get('/portfolio', [PortfolioController::class, 'portfolio'])->name('portfolio');
Route::get('/value', [ValueController::class, 'value'])->name('value');
Route::get('/feature', [FeatureController::class, 'feature'])->name('feature');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');

// Ödənişi başlat - form göndərildikdə işə düşür
Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');

// Callback - Kapitalbank ödənişdən sonra bura yönləndirir
Route::get('/payment/kapitalbank/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// Uğurlu ödəniş səhifəsi
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

// Uğursuz ödəniş səhifəsi
Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
