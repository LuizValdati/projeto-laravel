# Sistema de Registro de Atendimentos Médicos

Aplicação web para **registrar e consultar atendimentos médicos**, com API REST
em arquitetura de camadas, banco relacional e interface para cadastro e listagem.

## Tecnologias

- **PHP 8.4** / **Laravel 13**
- **MySQL 8**
- **Docker** + **Docker Compose** (nginx + php-fpm + mysql)
- **Frontend:** Blade + JavaScript puro (`fetch`) + CSS

## Arquitetura

A API segue a arquitetura em camadas, com cada camada responsável por uma coisa:

```
Controller  →  Service  →  Repository  →  Banco de dados
(HTTP)         (regras)     (acesso a dados via Eloquent)
```

- **Controller:** recebe a requisição, delega ao Service e devolve a resposta HTTP.
- **Service:** regras de negócio (resolve paciente/médico, define o status inicial).
- **Repository:** único ponto que acessa o banco. Cada repositório tem uma
  interface (contrato), com binding no `AppServiceProvider` (inversão de dependência).

### Modelagem do banco (normalizada)

```
pacientes (id, nome)
medicos   (id, nome)
atendimentos (id, paciente_id →FK, medico_id →FK, data_atendimento,
              valor_consulta, status, deleted_at)
```

Os dados do `atendimento.json` são importados via seeder, deduplicando pacientes
e médicos repetidos (`firstOrCreate`).

## Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/) (incluído no Docker Desktop)

## Como executar

```bash
# 1. Clonar o repositório
git clone <url-do-repositorio>
cd projeto-laravel

# 2. Criar o arquivo de ambiente
cp .env.example .env

# 3. Subir os containers (nginx + php-fpm + mysql)
docker compose up -d --build

# 4. Instalar as dependências do PHP
docker compose exec app composer install

# 5. Gerar a chave da aplicação
docker compose exec app php artisan key:generate

# 6. Criar as tabelas e importar os dados do atendimento.json
docker compose exec app php artisan migrate --seed
```

Pronto! Acesse a aplicação em **http://localhost:8080**

> Para recriar o banco do zero (limpando tudo e reimportando o JSON):
> `docker compose exec app php artisan migrate:fresh --seed`

## Telas

- **Listagem** — `http://localhost:8080/atendimentos`
- **Cadastro** — `http://localhost:8080/atendimentos/criar`

## API REST

| Método | Rota                  | Descrição                        |
|--------|-----------------------|----------------------------------|
| GET    | `/api/atendimentos`   | Lista todos os atendimentos      |
| POST   | `/api/atendimentos`   | Cadastra um novo atendimento     |

### Exemplo — cadastrar atendimento

```http
POST /api/atendimentos
Content-Type: application/json

{
    "nome_paciente": "João da Silva",
    "nome_medico": "Dra. Ana Martins",
    "data_atendimento": "2026-06-01",
    "valor_consulta": 180.00
}
```

Resposta `201 Created`:

```json
{
    "data": {
        "id": 21,
        "nome_paciente": "João da Silva",
        "nome_medico": "Dra. Ana Martins",
        "data_atendimento": "2026-06-01",
        "valor_consulta": "180.00",
        "status": "agendado"
    }
}
```

Em caso de dados inválidos, a API retorna `422` com as mensagens de erro em português.

## Decisões técnicas

- **Modelagem normalizada** (3 tabelas com chaves estrangeiras) para representar
  corretamente o relacionamento entre atendimentos, pacientes e médicos.
- **O cadastro cria paciente/médico caso não existam** — como não há tela
  dedicada para cadastrá-los, o formulário de atendimento aceita nomes e o
  sistema reaproveita o registro existente ou cria um novo.
- **`valor_consulta` como `decimal(10,2)`** para evitar imprecisão de ponto
  flutuante em valores monetários.
- **`status` via enum** (`agendado`, `realizado`, `cancelado`) com cast no model.
- **Soft delete** nos atendimentos (exclusão lógica via `deleted_at`).
- A API entrega os dados "crus"; a formatação de data e moeda é feita no frontend.

## Estrutura do projeto

```
app/
├── Enums/StatusAtendimento.php
├── Http/
│   ├── Controllers/Api/AtendimentoController.php
│   ├── Requests/StoreAtendimentoRequest.php   # validação
│   └── Resources/AtendimentoResource.php      # formatação do JSON
├── Models/                                    # Atendimento, Paciente, Medico
├── Repositories/
│   ├── Contracts/                             # interfaces
│   └── *Repository.php                        # implementações
└── Services/AtendimentoService.php

database/
├── migrations/
└── seeders/AtendimentoSeeder.php              # importa o atendimento.json
```

## Melhorias futuras

- Autenticação e auditoria (`created_by` — quem registrou o atendimento)
- Endpoints de edição e remoção
- Testes automatizados
