<form action="{{ route('cruds.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="col-md-12">
        <x-generator.input id="titulo" tipo="text" size="12" titulo="Nome do CRUD" :messages="$errors->updatePassword->get('name')"
            placeholder="Insira o nome do CRUD" mandatory="true" />

        <div id="generator-input"></div>
        <button id="generator-button" class="btn btn-primary mt-2">Adicionar Input</button>

        <div class="mt-2">
            <button class="btn btn-success" type="submit">
                Salvar
            </button>
        </div>
    </div>
</form>
