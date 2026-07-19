<?php

namespace App\Repositories;
use App\Models\Medico;
use App\Repositories\Contracts\MedicoRepositoryInterface;

class MedicoRepository implements MedicoRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function firstOrCreate(string $nome): Medico
    {
        return Medico::firstOrCreate(['nome' => $nome]);
    }
}
