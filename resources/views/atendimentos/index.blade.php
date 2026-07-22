@extends('layouts.app')

@section('conteudo')
<h1>Lista de Atendimentos</h1>

<div class="busca">
    <input type="text" id="busca-nome-paciente" placeholder="Buscar por nome do paciente">
    <input type="text" id="busca-nome-medico" placeholder="Buscar por nome do médico">

    <button class="btn" onclick="carregarAtendimentos()">Buscar</button>
    <button class="btn btn-secondary" onclick="limparCamposBusca()">Limpar</button>
</div>

<table>
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Médico</th>
            <th class="ordenavel" onclick="ordenarPor('data_atendimento')">Data <span class="seta" id="seta-data_atendimento"></span></th>
            <th class="ordenavel" onclick="ordenarPor('valor_consulta')">Valor <span class="seta" id="seta-valor_consulta"></span></th>
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

    var colunaAtualOrdenacao = 'data_atendimento';
    var direcaoAtualOrdenacao = 'desc';

    function ordenarPor(coluna) {
        if (colunaAtualOrdenacao === coluna) {
            direcaoAtualOrdenacao = direcaoAtualOrdenacao === 'asc' ? 'desc' : 'asc';
        } else {
            colunaAtualOrdenacao = coluna;
            direcaoAtualOrdenacao = 'asc';
        }
        carregarAtendimentos();
    }

    function atualizarSetas() {
        document.querySelectorAll('.seta').forEach(function (seta) {
            seta.textContent = '';
        });
        const setaAtiva = document.getElementById('seta-' + colunaAtualOrdenacao);
        if (setaAtiva) {
            setaAtiva.textContent = direcaoAtualOrdenacao === 'asc' ? '▲' : '▼';
        }
    }

    function limparCamposBusca() {
        document.getElementById('busca-nome-paciente').value = '';
        document.getElementById('busca-nome-medico').value = '';
        carregarAtendimentos();
    }

    function carregarAtendimentos() {
        atualizarSetas();

        const params = new URLSearchParams({
            nome_paciente: document.getElementById('busca-nome-paciente').value,
            nome_medico: document.getElementById('busca-nome-medico').value,
            ordenar_por: colunaAtualOrdenacao,
            direcao: direcaoAtualOrdenacao
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