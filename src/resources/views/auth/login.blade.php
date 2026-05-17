<x-guest-layout>

    <!-- Status de sessão -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" class="form-label text-dark fw-semibold" :value="__('Email')" />

            <x-text-input id="email" class="form-control mt-2" type="email" name="email" :value="old('email')" required
                autofocus />

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <x-input-label for="password" class="form-label text-dark fw-semibold" :value="__('Senha')" />

            <x-text-input id="password" class="form-control mt-2" type="password" name="password" required />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Lembrar-me -->
        <div class="form-check mt-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">

            <label class="form-check-label text-dark" for="remember_me">
                Lembrar-me
            </label>
        </div>

        <!-- Ações -->
        <div class="mt-4">

            @if (Route::has('password.request'))
                <a class="text-decoration-none text-primary fw-semibold" href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
            @endif

            <button class="btn btn-primary w-100 mt-3">
                Log in
            </button>

        </div>

    </form>

</x-guest-layout>