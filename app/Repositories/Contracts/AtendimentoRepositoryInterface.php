<?php

namespace App\Repositories\Contracts;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Atendimento;

interface AtendimentoRepositoryInterface
{
    public function all(array $filtros = []): Collection;

    public function create(array $data): Atendimento;
}
