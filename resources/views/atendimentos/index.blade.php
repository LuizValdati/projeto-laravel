@extends('layouts.app')

@section('conteudo')
<h1>Lista de Atendimentos</h1>

<div>
    <input type="text" id="busca-nome-paciente" placeholder="Buscar por nome do paciente">
    <input type="text" id="busca-nome-medico" placeholder="Buscar por nome do médico">

    <button onclick="carregarAtendimentos()">Buscar</button>
    <button onclick="limparCamposBusca()">Limpar</button>
</div>

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
    document.addEventListener('DOMContentLoaded', function() {
        carregarAtendimentos();
    });

    function limparCamposBusca() {
        document.getElementById('busca-nome-paciente').value = '';
        document.getElementById('busca-nome-medico').value = '';
        carregarAtendimentos();
    }

    function carregarAtendimentos() {
        const params = new URLSearchParams({
            nome_paciente: document.getElementById('busca-nome-paciente').value,
            nome_medico: document.getElementById('busca-nome-medico').value
        });
        const url = `/api/atendimentos?${params.toString()}`;

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                const atendimentosList = document.getElementById('atendimentos-list');
                atendimentosList.innerHTML = '';

                if (data.data.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="5" style="text-align: center;">Nenhum atendimento encontrado.</td>`;
                    atendimentosList.appendChild(row);
                    return;
                }

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
                }
            })
    }
</script>
@endpush