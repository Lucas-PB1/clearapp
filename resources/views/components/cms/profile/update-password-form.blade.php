<section class="mt-4 mb-3">
    <header>
        <h2 class="title-section"> Atualizar a senha </h2>
        <p> Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.
        </p>
    </header>

    <form method="post" action="{{ route('usuarios.update', Auth::user()->id) }}" class="mt-6">
        @csrf
        @method('put')
        <input type="text" class="form-control d-none" value="{{ Auth::user()->id }}" name="userId">

        <x-cms.campos.input identificador="current_password" classes="mt-2" tipo="password" titulo="Senha Atual"
            placeholder="Senha Atual" />

        <x-cms.campos.input identificador="password" classes="mt-2" titulo="Nova Senha" placeholder="Nova Senha"
            tipo="password" />

        <x-cms.campos.input identificador="password_confirmation" classes="mt-2" titulo="Confirmação de Senha"
            placeholder="Confirmação de Senha" tipo="password" />

        <div class="px-1 pt-2">
            <button class="btn btn-success">Salvar</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">Senha alterada
                    com sucesso</p>
            @endif
        </div>
    </form>
</section>
