<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendimentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome_paciente' => $this->paciente->nome,
            'nome_medico' => $this->medico->nome,
            'data_atendimento' => $this->data_atendimento->format('Y-m-d'),
            'valor_consulta' => $this->valor_consulta,
            'status' => $this->status->value,
        ];
    }
}
