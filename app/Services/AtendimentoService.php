<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

use App\Repositories\Contracts\AtendimentoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Repositories\Contracts\MedicoRepositoryInterface;
use App\Models\Atendimento;
use App\Enums\StatusAtendimento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AtendimentoService
{
    public function __construct(
        protected AtendimentoRepositoryInterface $atendimentoRepository,
        protected PacienteRepositoryInterface $pacienteRepository,
        protected MedicoRepositoryInterface $medicoRepository
    ) {}

    public function all(array $filtros = []): Collection
    {
        return $this->atendimentoRepository->all($filtros);
    }

    public function create(array $data): Atendimento
    {
        $atendimento = DB::transaction(function () use ($data) {
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
        });

        Log::info('Atendimento criado com sucesso.', ['atendimento' => $atendimento->id]);

        return $atendimento;
    }
}
