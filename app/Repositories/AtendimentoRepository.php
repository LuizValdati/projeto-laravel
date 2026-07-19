<?php

namespace App\Repositories;
use App\Repositories\Contracts\AtendimentoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Atendimento;

class AtendimentoRepository implements AtendimentoRepositoryInterface
{
    public function all(): Collection
    {
        return Atendimento::with(['paciente', 'medico'])->get();
    }

    public function create(array $data): Atendimento
    {
        return Atendimento::create($data);
    }
}
