<?php

use App\Enums\StatusAtendimento;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();

            // Chaves estrangeiras: cada atendimento pertence a um paciente e a um médico.
            // constrained() cria a FK apontando para as tabelas pacientes/medicos.
            // restrictOnDelete() impede apagar um paciente/médico que ainda tem atendimentos.
            $table->foreignId('paciente_id')->constrained('pacientes')->restrictOnDelete();
            $table->foreignId('medico_id')->constrained('medicos')->restrictOnDelete();

            $table->date('data_atendimento');
            $table->decimal('valor_consulta', 10, 2); // 10 dígitos, 2 casas decimais (dinheiro)

            // Status via enum. O default garante um valor válido em novos registros.
            $table->string('status')->default(StatusAtendimento::Agendado->value);

            $table->timestamps();
            $table->softDeletes(); // adiciona a coluna deleted_at (exclusão lógica)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};
