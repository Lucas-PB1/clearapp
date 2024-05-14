<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-cms.auth.input id="email" placeholder="example@gmail.com" type="email" classes="mt-2"
            titulo="E-mail" />
        <x-cms.auth.input id="password" placeholder="Senha" type="password" classes="mt-2" titulo="Senha" />
        <x-cms.auth.input id="password_confirmation" placeholder="Insira sua Senha Novamente" type="password"
            classes="mt-2" titulo="Confirmação a Senha" />

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
