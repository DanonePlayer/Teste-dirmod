<?php

namespace Tests\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\Cpf;
use InvalidArgumentException;
use Tests\TestCase;

class CpfTest extends TestCase
{
    public function test_deve_aceitar_cpf_valido()
    {
        $cpf = new Cpf('024.469.752-32');
        $this->assertEquals('02446975232', $cpf->value());
    }

    public function test_deve_barrar_cpf_com_todos_digitos_iguais()
    {
        $this->expectException(InvalidArgumentException::class);
        new Cpf('11111111111');
    }

    public function test_deve_barrar_cpf_tamanho_errado()
    {
        $this->expectException(InvalidArgumentException::class);
        new Cpf('123');
    }
}
