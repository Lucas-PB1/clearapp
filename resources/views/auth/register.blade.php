<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <x-cms.auth.input id="name" placeholder="Insira seu nome" type="text" classes="mt-2" titulo="Nome" />

        <x-cms.auth.input id="email" placeholder="example@gmail.com" type="email" classes="mt-2"
            titulo="E-mail" />

        <x-cms.auth.input id="password" placeholder="Insira sua Senha" type="password" classes="mt-2"
            titulo="Senha" />

        <x-cms.auth.input id="password_confirmation" placeholder="Insira sua Senha Novamente" type="password"
            classes="mt-2" titulo="Confirmação a Senha" />


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                Já Registrado?
            </a>

            <button class="btn btn-primary">
                Registre-se
            </button>
        </div>
    </form>
</x-guest-layout>
