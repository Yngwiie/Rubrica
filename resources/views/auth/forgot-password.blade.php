<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <span class="text-4xl font-extrabold pl-2 text-gray-300"><span class="text-4xl font-extrabold pl-2 text-white">Rubric</span>App</span>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('¿Olvidó su contraseña? No hay problema. Sólo danos tu dirección de correo electrónico y te enviaremos un enlace para restablecer la contraseña que te permitirá elegir una nueva.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('Registrarse') }}
                </a>
                <x-jet-button class="ml-4">
                    {{ __('Enviar Enlace') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
