<?php

namespace App\Application\UseCases;

use App\Application\DTOs\RegisterUserDTO;
use App\Domain\ValueObjects\Cpf;
use App\Domain\Repositories\AddressLookupInterface;
use App\Models\User;
use Exception;

class RegisterUserUseCase
{
    public function __construct(
        private AddressLookupInterface $addressService
    ) {}

    public function execute(RegisterUserDTO $dto): User
    {
        $cpf = new Cpf($dto->cpf);

        if (User::where('cpf', $cpf->value())->exists()) {
            throw new Exception("CPF já cadastrado no sistema.");
        }

        $address = $this->addressService->findByZipCode($dto->zipCode);

        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'cpf' => $cpf->value(),
            'zip_code' => $dto->zipCode,
            'street' => $address['logradouro'],
            'neighborhood' => $address['bairro'],
            'city' => $address['cidade'],
            'state' => $address['estado'],
            'password' => bcrypt($dto->password),
        ]);
    }
}
