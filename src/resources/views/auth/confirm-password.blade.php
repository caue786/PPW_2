<x-guest-layout>

    <!-- Texto -->
    <div class="mb-4 form-label text-dark fw-semibold">
        Confirme sua senha para continuar.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Senha -->
        <div>
            <x-input-label for="password" class="form-label text-dark fw-semibold" :value="__('Senha')" />

            <x-text-input id="password" class="form-control mt-2" type="password" name="password" required />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Botão -->
        <div class="mt-4">
            <button class="btn btn-primary w-100">
                Confirmar
            </button>
        </div>

    </form>

</x-guest-layout>