<?php

namespace App\Application\DTOs;

readonly class RegisterUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $cpf,
        public string $zipCode,
        public string $password
    ) {}
}
