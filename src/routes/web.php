<?php

Route::post('/create-payment', [Fzlxtech\LaravelRapyd\Http\Controllers\PaymentController::class, 'create_payment'])->name('create_payment');
Route::get('/countries', [Fzlxtech\LaravelRapyd\Http\Controllers\PaymentController::class, 'payment_methods_countries'])->name('countries');
Route::get('/required-fields', [Fzlxtech\LaravelRapyd\Http\Controllers\PaymentController::class, 'payment_methods_required_fields'])->name('fields');
Route::post('/create-payment-method', [Fzlxtech\LaravelRapyd\Http\Controllers\PaymentController::class, 'create_payment_methods'])->name('create_payment_method');
Route::post('/checkout', [Fzlxtech\LaravelRapyd\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
