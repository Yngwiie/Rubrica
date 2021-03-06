<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <span class="text-4xl font-extrabold pl-2 text-gray-300"><span class="text-4xl font-extrabold pl-2 text-white">Rubric</span>App</span>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-center mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('¿Olvidó su contraseña?') }}
                    </a>
                @endif
                <x-jet-button class="ml-4">
                    {{ __('Iniciar Sesión') }}
                </x-jet-button>
            </div>
            <hr>
            <div class="flex items-center justify-center mt-2">
                <span class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('¿No esta registrado? ') }}
                </span>
                <a style="margin-left:2px"class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('Registrarse') }}
                </a>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
