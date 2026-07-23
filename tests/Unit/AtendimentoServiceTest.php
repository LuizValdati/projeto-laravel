<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;

use App\Repositories\Contracts\AtendimentoRepositoryInterface;
use App\Repositories\Contracts\MedicoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Services\AtendimentoService;
use App\Models\Atendimento;
use Illuminate\Database\Eloquent\Collection;

class AtendimentoServiceTest extends TestCase
{
    public function test_lista_atendimentos_repassando_filtros(): void
    {
        $filtros = [
            'nome_paciente' => 'João',
            'nome_medico' => 'Dr. Silva',
            'ordenar_por' => 'data_atendimento',
            'direcao' => 'asc',
        ];
        $atendimentoRepo = Mockery::mock(AtendimentoRepositoryInterface::class);
        $medicoRepo = Mockery::mock(MedicoRepositoryInterface::class);
        $pacienteRepo = Mockery::mock(PacienteRepositoryInterface::class);

        $retornoFalso = new Collection([new Atendimento([
            'data_atendimento' => '2023-01-01',
            'valor_consulta' => 100.00,
        ])]);

        $atendimentoRepo->shouldReceive('all')->once()->with($filtros)->andReturn($retornoFalso);

        $service = new AtendimentoService($atendimentoRepo, $pacienteRepo, $medicoRepo);

        $this->assertEquals($retornoFalso, $service->all($filtros));
    }
}
