<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'DockFlix')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-light d-flex flex-column min-vh-100">

<!--  NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow border-bottom px-4">
    {{-- Navbar do Bootstrap --}}
    {{-- bg-white = fundo branco --}}
    {{-- shadow = sombra leve --}}
    {{-- border-bottom = linha inferior para separar do conteúdo --}}
    {{-- px-4 = espaçamento lateral --}}

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="/">
        {{-- navbar-brand = padrão Bootstrap para logo --}}
        {{-- d-flex + align-items-center = centraliza verticalmente --}}
        {{-- href="/" = redireciona para a home --}}

        <img src="/logo.png" style="height: 40px;" class="me-2">
        {{-- Imagem da logo personalizada --}}
        {{-- me-2 = margem à direita (espaço entre imagem e texto, se tivesse) --}}
    </a>

    <!-- Barra de pesquisa -->
    <form class="d-flex mx-auto w-50">
        {{-- d-flex = deixa input e botão lado a lado --}}
        {{-- mx-auto = centraliza horizontalmente --}}
        {{-- w-50 = ocupa 50% da largura --}}

        <input class="form-control me-2" type="search" placeholder="Pesquisar filmes...">
        {{-- form-control = estilo padrão do Bootstrap --}}
        {{-- me-2 = espaço entre input e botão --}}
        {{-- placeholder = texto dentro do campo --}}

        <button class="btn btn-primary">Buscar</button>
        {{-- Botão estilizado do Bootstrap --}}
    </form>

    <!-- Usuário -->
    <div class="d-flex align-items-center gap-3">
        {{-- d-flex = organiza em linha --}}
        {{-- align-items-center = alinha verticalmente --}}
        {{-- gap-3 = espaço entre os elementos --}}

        @guest
            {{-- Verifica se o usuário NÃO está logado --}}

            <!-- Silhueta -->
            <img src="/iconeuser.png" style="width: 35px; height: 35px;" class="rounded-circle">
            {{-- Imagem padrão de usuário --}}
            {{-- rounded-circle = deixa a imagem redonda --}}

            <a href="/login" class="btn btn-outline-primary btn-sm">Login</a>
            {{-- Botão de login --}}
            {{-- btn-outline-primary = estilo com borda --}}
            {{-- btn-sm = botão pequeno --}}

            <a href="/register" class="btn btn-primary btn-sm">Cadastrar</a>
            {{-- Botão de cadastro --}}
            {{-- btn-primary = botão preenchido --}}

        @else
            {{-- Se o usuário estiver logado --}}

            <span class="fw-semibold">{{ Auth::user()->name }}</span>
            {{-- Mostra o nome do usuário logado --}}
            {{-- Auth::user() pega o usuário atual --}}
            {{-- fw-semibold = deixa o texto mais destacado --}}

            <form method="POST" action="{{ route('logout') }}">
                {{-- Formulário para logout --}}
                {{-- Laravel exige POST para logout por segurança --}}

                @csrf
                {{-- Proteção contra ataques CSRF --}}

                <button class="btn btn-danger btn-sm">Sair</button>
                {{-- Botão de logout --}}
                {{-- btn-danger = vermelho (ação de sair) --}}
            </form>
        @endguest

    </div>
</nav>

    <!--  CONTEÚDO -->
    <main class="container mt-4 flex-fill">
        @yield('conteudo')
    </main>

    <footer class="bg-dark text-light text-center py-3 mt-4">
        © {{ date('Y') }} DOCK FLIX
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>