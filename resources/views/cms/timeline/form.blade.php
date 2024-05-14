@php $route = !isset($data) ? route('timeline.store') : route('timeline.update', $data->id) @endphp

<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf

    @isset($data)
        @method('PUT')
    @endisset

    <div class="row ms-0">

        <div class="row">
            <x-generator.input id="imagem-principal" titulo="Imagem de Fundo" size="6" tipo='file'
                :dados="isset($data) ? $data->destaque : null" />
        </div>

        <x-generator.input id="nome-do-evento" titulo="Nome do evento" size="6" tipo='text'
            dados="{{ isset($data) ? $data->{'nome-do-evento'} : null }}" placeholder="Nome do Evento" />

        <x-generator.input id="ordem" titulo="Ordem" size="6" tipo='text'
            dados="{{ isset($data) ? $data->{'ordem'} : null }}" />

        <x-generator.textarea id="texto" titulo="Texto" size="12" tipo='text'
            dados="{{ isset($data) ? $data->{'texto'} : null }}" />

    </div>
    <div class="p-3">
        <button class="btn btn-primary" type="submit">
            Enviar
        </button>
    </div>
</form>
