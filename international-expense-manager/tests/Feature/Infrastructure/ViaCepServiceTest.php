<?php

namespace Tests\Feature\Infrastructure;

use App\Infrastructure\Services\ViaCepService;
use Tests\TestCase;

class ViaCepServiceTest extends TestCase
{
    public function test_deve_retornar_endereco_atraves_do_cep()
    {
        $service = new ViaCepService();
        $result = $service->findByZipCode('69901154');

        // dump($result);

        $this->assertEquals("Rua Marte", $result['logradouro']);
        $this->assertEquals("Rio Branco", $result['cidade']);
    }
}
