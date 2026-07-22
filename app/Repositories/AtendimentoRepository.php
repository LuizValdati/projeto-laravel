<?php

namespace App\Repositories;

use App\Repositories\Contracts\AtendimentoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Atendimento;

class AtendimentoRepository implements AtendimentoRepositoryInterface
{
    public function all(array $filtros = []): Collection
    {
        return Atendimento::with(['paciente', 'medico'])
            ->when($filtros['nome_paciente'] ?? null, function ($query, $nomePaciente) {
                $query->whereHas('paciente', function ($q) use ($nomePaciente) {
                    $q->where('nome', 'like', "%{$nomePaciente}%");
                });
            })
            ->when($filtros['nome_medico'] ?? null, function ($query, $nomeMedico) {
                $query->whereHas('medico', function ($q) use ($nomeMedico) {
                    $q->where('nome', 'like', "%{$nomeMedico}%");
                });
            })
            ->get();
    }

    public function create(array $data): Atendimento
    {
        return Atendimento::create($data);
    }
}
