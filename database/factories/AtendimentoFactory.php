<?php

namespace Database\Factories;

use App\Enums\StatusAtendimento;
use App\Models\Atendimento;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Atendimento>
 */
class AtendimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paciente = Paciente::factory();
        $medico = Medico::factory();

        return [
            'paciente_id' => $paciente,
            'medico_id' => $medico,
            'data_atendimento' => fake()->date(),
            'valor_consulta' => fake()->randomFloat(2, 100, 1000),
            'status' => fake()->randomElement([
                StatusAtendimento::Agendado,
                StatusAtendimento::Realizado,
                StatusAtendimento::Cancelado,
            ]),
        ];
    }
}
