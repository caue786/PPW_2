<x-guest-layout>

    <!-- Texto -->
    <div class="mb-4 form-label text-dark fw-semibold">
        Obrigado por se cadastrar! Antes de começar, verifique seu email clicando no link que enviamos.
        Caso não tenha recebido, você pode solicitar outro.
    </div>

    <!-- Status -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-success text-center fw-semibold">
            Um novo link de verificação foi enviado para o seu email.
        </div>
    @endif

    <div class="mt-4">

        <!-- Reenviar email -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button class="btn btn-primary w-100">
                Reenviar email de verificação
            </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">
            @csrf

            <button type="submit" class="btn btn-link text-decoration-none text-danger fw-semibold">
                Sair
            </button>
        </form>

    </div>

</x-guest-layout>