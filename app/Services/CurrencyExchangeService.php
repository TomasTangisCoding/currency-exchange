<?php

namespace App\Services;

class CurrencyExchangeService
{
    protected $currencyRateMap;

    public function __construct($currencyRateMap)
    {
        $this->currencyRateMap = $currencyRateMap['currencies'];
    }

    public function __invoke($input)
    {
        $amount = round(str_replace(',', '', $input['amount']), 2);
        $rateFormSourceToTarget = (float)$this->currencyRateMap[$input['source']][$input['target']];
        $targetAmount = round($amount * $rateFormSourceToTarget, 2);
        $formattedAmount = number_format($targetAmount, 2, ".", ",");

        return $formattedAmount;
    }
}