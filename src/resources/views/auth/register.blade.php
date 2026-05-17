<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nome -->
        <div>
            <x-input-label for="name" class="form-label text-dark fw-semibold" :value="__('Nome')" />

            <x-text-input id="name" class="form-control mt-2" type="text" name="name" :value="old('name')" required
                autofocus />

            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" class="form-label text-dark fw-semibold" :value="__('Email')" />

            <x-text-input id="email" class="form-control mt-2" type="email" name="email" :value="old('email')"
                required />

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <x-input-label for="password" class="form-label text-dark fw-semibold" :value="__('Senha')" />

            <x-text-input id="password" class="form-control mt-2" type="password" name="password" required />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Confirmar Senha -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" class="form-label text-dark fw-semibold" :value="__('Confirmar Senha')" />

            <x-text-input id="password_confirmation" class="form-control mt-2" type="password"
                name="password_confirmation" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <!-- Ações -->
        <div class="mt-4">

            <a class="text-decoration-none text-primary fw-semibold" href="{{ route('login') }}">
                Já tem conta? Faça login
            </a>

            <button class="btn btn-primary w-100 mt-3">
                Registrar
            </button>

        </div>

    </form>

</x-guest-layout>