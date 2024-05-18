<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRequest;

abstract class Controller
{
    public function currencyExchange(CurrencyExchangeRequest $request){}
}
