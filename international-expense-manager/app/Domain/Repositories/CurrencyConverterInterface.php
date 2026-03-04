<?php

namespace App\Domain\Repositories;

interface CurrencyConverterInterface
{
    public function getExchangeRate(string $currency): float;
}
