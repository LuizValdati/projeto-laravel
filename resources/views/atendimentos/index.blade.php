@extends('layouts.app')

@section('conteudo')
<h1>Lista de Atendimentos</h1>

<table>
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="atendimentos-list">
        <tr>
            <td colspan="5" style="text-align: center;">Carregando atendimentos...</td>
        </tr>
    </tbody>
</table>
@endsection

@push('scripts')
<script>
    fetch('/api/atendimentos')
        .then((response) => response.json())
            .then((data) => {
                const atendimentosList = document.getElementById('atendimentos-list');
                atendimentosList.innerHTML = '';

                for (const atendimento of data.data) {
                    const data_atendimento_formatada = atendimento.data_atendimento.split('-').reverse().join('/');
                    const valor_consulta_formatado = new Intl.NumberFormat("pt-BR", {
                        style: "currency",
                        currency: "BRL"
                    }).format(atendimento.valor_consulta);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${atendimento.nome_paciente}</td>
                    <td>${atendimento.nome_medico}</td>
                    <td>${data_atendimento_formatada}</td>
                    <td>${valor_consulta_formatado}</td>
                    <td>${atendimento.status}</td>
                `;
                    atendimentosList.appendChild(row);
                };
            })
</script>
@endpush