<?php

namespace App\Models;

use App\Enums\StatusAtendimento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atendimento extends Model
{
    use SoftDeletes; // habilita a exclusão lógica (usa a coluna deleted_at)
    use HasFactory;

    /**
     * Campos que podem ser preenchidos em massa (create/update com array).
     * Protege contra "mass assignment" de colunas indesejadas.
     */
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'data_atendimento',
        'valor_consulta',
        'status',
    ];

    /**
     * Conversões automáticas de tipo ao ler/gravar.
     * O Eloquent transforma a string do banco em objeto tipado e vice-versa.
     */
    protected function casts(): array
    {
        return [
            'data_atendimento' => 'date',
            'valor_consulta' => 'decimal:2',
            'status' => StatusAtendimento::class,
        ];
    }

    /**
     * Um atendimento pertence a um paciente.
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Um atendimento pertence a um médico.
     */
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }
}
