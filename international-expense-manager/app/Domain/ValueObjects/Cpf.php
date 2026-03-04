<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Cpf
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $this->sanitize($value);
        $this->validate();
    }

    private function sanitize(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }

    private function validate(): void
    {
        if (!$this->hasElevenDigits() || $this->hasAllDigitsEqual()) {
            throw new InvalidArgumentException("CPF Inválido: Formato incorreto ou números repetidos.");
        }

        if (!$this->validateDigits()) {
            throw new InvalidArgumentException("CPF Inválido: Dígito verificador não confere.");
        }
    }

    private function hasElevenDigits(): bool
    {
        return strlen($this->value) === 11;
    }

    private function hasAllDigitsEqual(): bool
    {
        return preg_match('/(\d)\1{10}/', $this->value);
    }

    private function validateDigits(): bool
    {
        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($count = 0; $count < $t; $count++) {
                $sum += $this->value[$count] * (($t + 1) - $count);
            }

            $digit = ((10 * $sum) % 11) % 10;

            if ($this->value[$t] != $digit) {
                return false;
            }
        }
        return true;
    }

    public function value(): string
    {
        return $this->value;
    }
}
