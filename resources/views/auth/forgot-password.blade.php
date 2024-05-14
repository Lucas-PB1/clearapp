<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Esqueceu sua senha? Sem problemas. Apenas informe seu endereço de e-mail que enviaremos um link que permitirá
        definir uma nova senha.
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <x-cms.auth.input id="email" placeholder="example@gmail.com" type="email" classes="mt-2"
            titulo="E-mail" />

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-primary">
                Enviar link para redefinição de conta por email
            </button>
        </div>
    </form>
</x-guest-layout>
