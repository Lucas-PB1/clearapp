<x-cms-layout>
    <x-cms.partials.forms.card>
        <section class="mt-4 mb-3">
            <header>
                <h2> Cadastrar usuário </h2>
                <p> Preencha os campos abaixo para criar um novo usuário. </p>
            </header>

            @if (session('status'))
                <div class="alert alert-success mt-2" role="alert">
                    Usuário Criado com Sucesso!
                </div>
            @endif

            <form method="post" action="{{ route('usuarios.store') }}" class="mt-6">
                @csrf

                <x-cms.campos.input identificador="name" classes="mt-2" tipo="text" titulo="Nome"
                    placeholder="Nome de usuário" />

                <x-cms.campos.input identificador="email" classes="mt-2" tipo="email" titulo="E-mail"
                    placeholder="example@gmail.com" />

                <x-cms.campos.input identificador="password" classes="mt-2" tipo="password" titulo="Senha"
                    placeholder="********" />

                <x-cms.campos.input identificador="password_confirmation" classes="mt-2" tipo="password"
                    titulo="Confirmação de Senha" placeholder="********" />

                <x-cms.campos.cargos :roles="$roles" />

                @can(['create_usuarios', 'update_usuarios'])
                    <div class="mt-3">
                        <button class="btn btn-success">Criar Usuário</button>
                    </div>
                @endcan
            </form>
        </section>
    </x-cms.partials.forms.card>
</x-cms-layout>
