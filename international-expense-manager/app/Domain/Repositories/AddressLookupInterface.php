<?php

namespace App\Domain\Repositories;

interface AddressLookupInterface
{
    public function findByZipCode(string $zipCode): array;
}
