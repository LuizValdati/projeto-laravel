<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

use App\Repositories\Contracts\AtendimentoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Repositories\Contracts\MedicoRepositoryInterface;
use App\Models\Atendimento;
use App\Enums\StatusAtendimento;

class AtendimentoService
{
    public function __construct(
        protected AtendimentoRepositoryInterface $atendimentoRepository,
        protected PacienteRepositoryInterface $pacienteRepository,
        protected MedicoRepositoryInterface $medicoRepository
    )
    {
        
    }

    public function all(): Collection
    {
        return $this->atendimentoRepository->all();
    }

    public function create(array $data): Atendimento
    {
        $paciente = $this->pacienteRepository->firstOrCreate($data['nome_paciente']);
        $medico = $this->medicoRepository->firstOrCreate($data['nome_medico']);

        $atendimentoData = [
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'data_atendimento' => $data['data_atendimento'],
            'valor_consulta' => $data['valor_consulta'],
            'status' => StatusAtendimento::Agendado,
        ];

        return $this->atendimentoRepository->create($atendimentoData);
    }
}
