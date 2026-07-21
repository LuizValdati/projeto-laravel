<?php

namespace App\Repositories\Contracts;
use App\Models\Medico;

interface MedicoRepositoryInterface
{
    public function firstOrCreate(string $nome): Medico;
}
