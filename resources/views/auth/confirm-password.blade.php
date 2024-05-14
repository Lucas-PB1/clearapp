<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <x-cms.auth.input id="password" placeholder="Senha" type="password" classes="mt-2" titulo="Senha" />

        <div class="flex justify-end mt-4">
            <button class="btn btn-primary">
                Confirmar
            </button>
        </div>
    </form>
</x-guest-layout>
