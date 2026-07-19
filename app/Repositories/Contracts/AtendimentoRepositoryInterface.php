<?php

namespace App\Repositories\Contracts;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Atendimento;

interface AtendimentoRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): Atendimento;
}
