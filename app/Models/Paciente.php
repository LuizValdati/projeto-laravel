<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;

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
