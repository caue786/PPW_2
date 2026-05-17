<x-guest-layout>
    <div class="mb-4 form-label text-dark fw-semibold">
        {{ __('Esqueceu sua senha? Sem problemas. Apenas nos deixe saber seu  endereço de email e nos vamos enviar um link para que você possa redefinir sua senha.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
         <div class="mt-4">
            <x-input-label for="email" class="form-label text-dark fw-semibold" :value="__('Email')" />

            <x-text-input id="email" class="form-control mt-2" type="email" name="email" :value="old('email')"
                required />

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

       <button class="btn btn-primary w-100 mt-3">
    Enviar link de redefinição
</button>
    </form>
</x-guest-layout>
