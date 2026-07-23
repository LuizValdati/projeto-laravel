<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\Medico;


class AtendimentoApiTest extends TestCase
{

    use RefreshDatabase;

    public function test_lista_atendimentos_com_sucesso(): void
    {
        Atendimento::factory()->count(5)->create();

        $response = $this->getJson('/api/atendimentos');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nome_paciente',
                        'nome_medico',
                        'data_atendimento',
                        'valor_consulta',
                        'status'
                    ]
                ]
            ]);
    }

    public function test_busca_atendimentos_por_paciente(): void
    {
        $paciente = Paciente::factory()->create(['nome' => 'João']);
    
        Atendimento::factory()->create(['paciente_id' => $paciente->id]);
        Atendimento::factory()->count(5)->create();

        $response = $this->getJson('/api/atendimentos?nome_paciente=João');

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.0.nome_paciente', 'João');
    }

    public function test_ordena_atendimentos_por_valor(): void
    {
        $valores = [100, 200, 500, 7, 562];

    Atendimento::factory()
        ->count(5)
        ->sequence(
                fn ($sequence) => ['valor_consulta' => $valores[$sequence->index]]
            )        
        ->create();

        $response = $this->getJson('/api/atendimentos?ordenar_por=valor_consulta&direcao=asc');

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.0.valor_consulta', '7.00');
    }
    
    public function test_cadastra_atendimento_com_sucesso(): void
    {

    $atendimento = ['nome_paciente' => Paciente::factory()->create()->nome,
                    'nome_medico' => Medico::factory()->create()->nome,
                    'data_atendimento' => fake()->date(),
                    'valor_consulta' => 789];

        $response = $this->postJson('/api/atendimentos', $atendimento);

        $response
            ->assertStatus(201);

        $this
            ->assertDatabaseHas('atendimentos', ['valor_consulta' => 789]);
    }

    public function test_nao_cadastra_atendimento_com_dados_invalidos(): void
    {
        $response = $this->postJson('/api/atendimentos', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'nome_paciente',
                'nome_medico',
                'data_atendimento',
                'valor_consulta'
            ]);
    }
}
