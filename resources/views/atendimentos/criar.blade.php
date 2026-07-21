@extends('layouts.app')

@section('conteudo')
    <h1>Novo Atendimento</h1>

    <div id="mensagens"></div>

    <form id="form">
        <label for="nome_paciente">Nome do Paciente:</label>
        <input type="text" name="nome_paciente" id="nome_paciente">
        <label for="nome_medico">Nome do Médico:</label>
        <input type="text" name="nome_medico" id="nome_medico">
        <label for="data_atendimento">Data do Atendimento:</label>
        <input type="date" name="data_atendimento" id="data_atendimento">
        <label for="valor_consulta">Valor da Consulta:</label>
        <input type="number" name="valor_consulta" id="valor_consulta" step="0.01">

        <button type="submit">Cadastrar Atendimento</button>
    </form>
@endsection

@push('scripts')
<script>
    const form = document.getElementById('form');
    const mensagensDiv = document.getElementById('mensagens');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const response = await fetch('/api/atendimentos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (response.ok) {
            mensagensDiv.innerHTML = `<p style="color: green;">✅ Atendimento cadastrado com sucesso!</p>`;
            form.reset();
        } else {
            const mensagens = Object.values(result.errors).flat();

            const html = mensagens.map(msg => `<li style="color: red;">${msg}</li>`).join('');
            mensagensDiv.innerHTML = `<p style="color:red;">❌ Erro ao cadastrar:</p><ul>${html}</ul>`;
        }
    });
</script>
@endpush