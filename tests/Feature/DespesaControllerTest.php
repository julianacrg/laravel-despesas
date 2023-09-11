<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Despesa;

class DespesaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_de_despesas_retorna_status_ok()
    {
        $response = $this->get('/api/despesas');

        $response->assertStatus(200);
    }

}
