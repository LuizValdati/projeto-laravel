<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <title>Registro de Atendimentos</title>
</head>
<body>
    <header class="topbar">
        <div class="topbar__inner">
            <span class="brand">Atendimentos Médicos</span>
            <nav class="menu">
                <a href="/atendimentos">Atendimentos</a>
                <a href="/atendimentos/criar">Novo atendimento</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('conteudo')
    </main>

    @stack('scripts')
</body>
</html>