<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\CurrencyConversionController;

class CurrencyTest extends TestCase
{
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_currency_conversion(){
        $result = (new CurrencyConversionController)->getConvertedPrice(100, "usd", "eur");
        $this->assertEquals(98, $result);
    }
}
