<?php

namespace Database\Seeders;

use App\Enums\StatusAtendimento;
use App\Models\Atendimento;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class AtendimentoSeeder extends Seeder
{
    /**
     * Importa os registros do arquivo atendimento.json para o banco.
     */
    public function run(): void
    {
        // Lê o JSON da raiz do projeto e transforma em array.
        $caminho = base_path('atendimento.json');
        $registros = json_decode(file_get_contents($caminho), true);

        foreach ($registros as $registro) {
            // firstOrCreate evita duplicar: se o paciente/médico já existe
            // (mesmo nome), reaproveita; senão, cria. É o que normaliza os dados.
            $paciente = Paciente::firstOrCreate(['nome' => $registro['nome_paciente']]);
            $medico = Medico::firstOrCreate(['nome' => $registro['nome_medico']]);

            Atendimento::create([
                'paciente_id' => $paciente->id,
                'medico_id' => $medico->id,
                'data_atendimento' => $registro['data_atendimento'],
                'valor_consulta' => $registro['valor_consulta'],
                // Os dados do JSON são de datas passadas, então marcamos como realizados.
                'status' => StatusAtendimento::Realizado,
            ]);
        }
    }
}
