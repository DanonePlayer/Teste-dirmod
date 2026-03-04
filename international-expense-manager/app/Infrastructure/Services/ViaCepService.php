<?php

namespace App\Infrastructure\Services;

use App\Domain\Repositories\AddressLookupInterface;
use Illuminate\Support\Facades\Http;

class ViaCepService implements AddressLookupInterface
{
    public function findByZipCode(string $zipCode): array
    {
        $response = Http::get("https://viacep.com.br/ws/{$zipCode}/json/")->json();

        if (isset($response['erro'])) throw new \Exception("CEP não encontrado.");

        return [
            'logradouro' => $response['logradouro'],
            'bairro' => $response['bairro'],
            'cidade' => $response['localidade'],
            'estado' => $response['uf'],
        ];
    }
}
