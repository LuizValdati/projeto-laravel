<?php

namespace App\Repositories\Contracts;
use App\Models\Paciente;

interface PacienteRepositoryInterface
{
    public function firstOrCreate(string $nome): Paciente;
}
