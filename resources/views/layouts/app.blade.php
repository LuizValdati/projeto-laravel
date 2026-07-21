<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Atendimentos</title>
</head>
<body>
    <nav>
        <a href="/atendimentos">Atendimentos</a>
        <a href="/atendimentos/criar">Criar Atendimento</a>
    </nav>
    
    @yield('conteudo')

    @stack('scripts')
</body>
</html>