<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>DockFlix</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light"></body><!-- 🔵 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="/logo.png" style="height: 40px;" class="me-2">
        <strong>DockFlix</strong>
    </a>

    <!-- Barra de pesquisa -->
    <form class="d-flex mx-auto w-50">
        <input class="form-control me-2" type="search" placeholder="Pesquisar filmes...">
        <button class="btn btn-primary">Buscar</button>
    </form>

    <!-- Usuário -->
    <div class="d-flex align-items-center gap-3">

        <!-- Ícone usuário -->
        <img src="/user.png" style="width: 35px; height: 35px;" class="rounded-circle">

        <!-- Menu -->
        @guest
            <a href="/login" class="btn btn-outline-primary btn-sm">Login</a>
            <a href="/register" class="btn btn-primary btn-sm">Cadastrar</a>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">Sair</button>
            </form>
        @endguest

    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>