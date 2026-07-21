<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    protected $fillable = [
        'nome',
    ];

    /**
     * Um paciente tem muitos atendimentos.
     */
    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class);
    }
}
