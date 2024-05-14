<section class="mt-4 mb-3">
    <header>
        <h2 class="title-section"> Gerenciar Cargos </h2>
        <p> Atribua ou remova cargos para este usuário. </p>
    </header>

    <form method="post" action="{{ route('usuarios.update', $user->id) }}" class="mt-6">
        @csrf
        @method('put')
        <input type="text" class="form-control d-none" value="{{ $user->id }}" name="userId">

       <x-cms.campos.cargos :roles="$roles" :user="$user"/>

        <div class="mt-3">
            <button class="btn btn-success">Atualizar Cargos</button>

            @if (session('status') === 'roles-updated')
                <div class="alert alert-success mt-2" role="alert">
                    Cargos atualizados com sucesso
                </div>
            @endif
        </div>
    </form>
</section>
