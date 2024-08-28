<form action="{{ route('cruds.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="col-md-12">
        <x-generator.input id="titulo" tipo="text" size="12" titulo="Nome do CRUD" placeholder="Nome" mandatory="true"/>

        <div id="generator-input"></div>
        <button id="generator-button" class="btn btn-primary mt-2">Adicionar Input</button>

        <div class="row">
            <x-generator.input id="galeria" tipo="checkbox" size="6" titulo="Galeria?"/>
            <x-generator.input id="imagem-destaque" tipo="checkbox" size="6" titulo="Imagem de destaque?"/>
        </div>

        <div class="mt-2">
            <button class="btn btn-success" type="submit">
                Salvar
            </button>
        </div>
    </div>
</form>
