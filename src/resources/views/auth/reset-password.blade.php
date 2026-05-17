<<x-guest-layout>

    <div class="mb-4 form-label text-dark fw-semibold">
        Defina uma nova senha para sua conta.
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <x-input-label for="email" class="form-label text-dark fw-semibold" :value="__('Email')" 
            />

            <x-text-input id="email" class="form-control mt-2" type="email" name="email" :value="old('email', $request->email)" required />

            <x-input-error :messages="$errors->get('email')"  class="mt-2 text-danger"/>
        </div>

        <!-- Nova senha -->
        <div class="mt-4">
            <x-input-label for="password" class="form-label text-dark fw-semibold" :value="__('Nova senha')" />

            <x-text-input id="password" class="form-control mt-2" type="password" name="password" required />

            <x-input-error :messages="$errors->get('password')"class="mt-2 text-danger"  />
        </div>

        <!-- Confirmar senha -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" class="form-label text-dark fw-semibold" :value="__('Confirmar senha')" />

            <x-text-input  id="password_confirmation"  class="form-control mt-2" type="password" name="password_confirmation" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <!-- Botão -->
        <div class="mt-4">
            <button class="btn btn-primary w-100">
                Redefinir senha
            </button>
        </div>

    </form>

</x-guest-layout>