<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    /**
     * Um médico tem muitos atendimentos.
     */
    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class);
    }
}
