<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyService;

class CurrencyConversionController extends Controller
{

    public function getConvertedPrice($amount, $currencyFrom, $currencyTo){
        return (new CurrencyService)->convert($amount, $currencyFrom, $currencyTo);
    }

}
