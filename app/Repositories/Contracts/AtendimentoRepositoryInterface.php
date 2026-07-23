<?php

namespace App\Repositories\Contracts;

use App\Models\Atendimento;
use Illuminate\Database\Eloquent\Collection;

interface AtendimentoRepositoryInterface
{
    public function all(array $filtros = []): Collection;

    public function create(array $data): Atendimento;
}
