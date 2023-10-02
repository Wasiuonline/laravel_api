<?php

namespace App\Services;

Class CurrencyService{

    const RATE = [
        'usd' => [
            'eur' => 0.98
        ]
        ];

    public function convert($amount, $currencyFrom, $currencyTo){
        $rate = self::RATE[$currencyFrom][$currencyTo] ?? 0;
        return round($amount * $rate, 2);
    }
}

?>