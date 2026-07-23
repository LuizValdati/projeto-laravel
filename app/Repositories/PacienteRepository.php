<?php

namespace App\Repositories;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;

class PacienteRepository implements PacienteRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function firstOrCreate(string $nome): Paciente
    {
        return Paciente::firstOrCreate(['nome' => $nome]);
    }
}
