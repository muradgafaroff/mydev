<?php

use Illuminate\Support\Facades\Route;
use AZPayments\Kapitalbank\Http\Controllers\KapitalbankController;

Route::prefix('payment/kapitalbank')->name('kapitalbank.')->group(function () {
    
    // Callback URL - ödəniş tamamlandıqdan sonra
    Route::get('/callback', [KapitalbankController::class, 'callback'])
        ->name('callback');
    
    // Uğurlu ödəniş səhifəsi
    Route::get('/success', [KapitalbankController::class, 'success'])
        ->name('success');
    
    // Uğursuz ödəniş səhifəsi
    Route::get('/error', [KapitalbankController::class, 'error'])
        ->name('error');

});