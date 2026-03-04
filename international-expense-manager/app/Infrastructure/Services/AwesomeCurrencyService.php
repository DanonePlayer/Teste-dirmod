<?php

namespace App\Infrastructure\Services;

use App\Domain\Repositories\CurrencyConverterInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class AwesomeCurrencyService implements CurrencyConverterInterface
{
    public function getExchangeRate(string $fromCurrency): float
    {
        $response = Http::get("https://economia.awesomeapi.com.br/json/last/{$fromCurrency}-BRL");

        if ($response->failed()) {
            throw new Exception("Falha ao consultar cotação da moeda {$fromCurrency}.");
        }

        $data = $response->json();
        $key = "{$fromCurrency}BRL";

        return (float) $data[$key]['bid'];
    }
}
