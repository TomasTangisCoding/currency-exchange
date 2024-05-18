<?php

namespace App\Services;

class CurrencyExchangeService
{
    protected $currencyRateMap;

    public function __construct($currencyRateMap)
    {
        $this->currencyRateMap = $currencyRateMap['currencies'];
    }

    public function __invoke($requestData)
    {
        $amount = (float)round(str_replace(',', '', $requestData['amount']), 2);
        $rateFormSourceToTarget = (float)$this->currencyRateMap[$requestData['source']][$requestData['target']];
        $targetAmount = round($amount * $rateFormSourceToTarget, 2);
        $formattedAmount = number_format($targetAmount, 2, ".", ",");

        return $formattedAmount;
    }
}