<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyExchangeRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\CurrencyExchangeService;

class CurrencyExchangeController extends Controller
{
    public function currencyExchange(CurrencyExchangeRequest $request)
    {
        $input = $request->all();

        $input['amount'] = str_replace(',', '', $input['amount']);

        $currencyRateMap = json_decode('{"currencies":{"TWD":{"TWD":1,"JPY":3.669,"USD":0.03281},"JPY":{"TWD":0.26956,"JPY":1,"USD":0.00885},"USD":{"TWD":30.444,"JPY":111.801,"USD":1}}}', true);

        if ($message = $this->isCurrencyPairInvalid($currencyRateMap, $input['source'], $input['target'])) {
            return response([
                'success' => false,
                'message' => $message
            ], 400);
        }

        $CurrencyExchanger = new CurrencyExchangeService($currencyRateMap);
        
        return response([
            'success' => true,
            'converted_amount' => $CurrencyExchanger($input)
        ]); 
    }

    private function isCurrencyPairInvalid($currencyRateMap, $source, $target)
    {
        if (empty($currencyRateMap['currencies'][$source])) {
            return 'The source currency is not supported.';
        }

        if (empty($currencyRateMap['currencies'][$source][$target])) {
            return 'The target currency is not supported.';
        }
        
        return false;
    }
}
