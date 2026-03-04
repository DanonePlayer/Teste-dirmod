<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\CurrencyConverterInterface;
use App\Models\Expense;

class RegisterExpenseUseCase
{
    public function __construct(
        private CurrencyConverterInterface $currencyService
    ) {}

    public function execute(array $data): Expense
    {
        $rate = $this->currencyService->getExchangeRate($data['currency']);
        $convertedAmount = $data['original_amount'] * $rate;

        return Expense::create([
            'user_id' => $data['user_id'],
            'description' => $data['description'],
            'original_amount' => $data['original_amount'],
            'currency' => strtoupper($data['currency']),
            'exchange_rate' => $rate,
            'converted_amount_brl' => $convertedAmount,
        ]);
    }
}
