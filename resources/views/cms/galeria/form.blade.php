@php $route = !isset($data) ? route('galeria.store') : route('galeria.update', $data->id) @endphp

<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf

    @isset($data)
        @method('PUT')
    @endisset

    <div class="row ms-0">
        <div class="row">
            <x-generator.input id="imagem-principal" titulo="Imagem de Fundo" size="6" tipo='file'
                :dados="isset($data) ? $data->destaque : null" />

            <div class="col-md-12">
                @isset($data)
                    <x-generator.input id="slug" titulo="URL" size="6" tipo='text'
                        placeholder="Insira a slug" dados="{{ isset($data) ? $data->{'slug'} : null }}" mandatory="true"
                        prepend="http://jardim/" linkRoute="{{ route('jardim.index', $data->slug) }}" />
                @endisset
            </div>
        </div>

        <x-generator.input id="nome-da-galeria" titulo="Nome da Galeria" size="6" tipo='text'
            dados="{{ isset($data) ? $data->{'nome-da-galeria'} : null }}" placeholder="Nome da Galeria" />

        <x-generator.input-icon size="6" id="icone" titulo="Ícone" :dados="isset($data) ? $data->{'icone'} : null" mandatory="true" />

    </div>
    <div class="p-3">
        <button class="btn btn-primary" type="submit">
            Enviar
        </button>
    </div>
</form>

@isset($data)
    <div class="row">
        <x-cms.partials.galery :id="$data->id" table="Galeria" />
    </div>
@endisset