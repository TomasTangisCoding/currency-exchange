<?php

use App\Http\Controllers\CurrencyExchangeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currencyExchange', [CurrencyExchangeController::class, 'currencyExchange'])->name('currencyExchange');