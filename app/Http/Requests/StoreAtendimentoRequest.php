<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAtendimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_paciente' => ['required', 'string', 'max:255'],
            'nome_medico' => ['required', 'string', 'max:255'],
            'data_atendimento' => ['required', 'date'],
            'valor_consulta' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome_paciente.required' => 'O nome do paciente é obrigatório.',
            'nome_paciente.max' => 'O nome do paciente não pode exceder 255 caracteres.',
            'nome_medico.required' => 'O nome do médico é obrigatório.',
            'nome_medico.max' => 'O nome do médico não pode exceder 255 caracteres.',
            'data_atendimento.required' => 'A data do atendimento é obrigatória.',
            'data_atendimento.date' => 'A data do atendimento deve ser uma data válida.',
            'valor_consulta.required' => 'O valor da consulta é obrigatório.',
            'valor_consulta.numeric' => 'O valor da consulta deve ser um número.',
            'valor_consulta.min' => 'O valor da consulta não pode ser negativo.',
        ];
    }
}
