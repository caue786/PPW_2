<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sistema')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">DOCK FLIX</a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/produtos">Produtos</a>
            </div>
        </div>
    </nav>

    <main class="container mt-4 flex-fill">
        @yield('conteudo')
    </main>

    <footer class="bg-dark text-light text-center py-3 mt-4">
        <p class="mb-0">&copy; {{ date('Y') }} DOCK FLIX</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>