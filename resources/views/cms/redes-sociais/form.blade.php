@php $route = !isset($data) ? route('redes-sociais.store') : route('redes-sociais.update', $data->id) @endphp

<form action="{{ $route }}" method="post">
    @csrf

    @isset($data)
        @method('PUT')
    @endisset

    <div class="row ms-0">
        <x-generator.input id="nome" titulo="Nome" size="6" tipo='text'
            dados="{{ isset($data) ? $data->{'nome'} : null }}" placeholder="Insira o nome da Rede Social" maxlength="80" />

        <x-generator.input-icon size="6" id="icone" titulo="Ícone" :dados="isset($data) ? $data->{'icone'} : null" mandatory="true" />

        <x-generator.input id="link" titulo="Link" size="12" tipo='text'
            dados="{{ isset($data) ? $data->{'link'} : null }}" placeholder="example@site.com.br" />

    </div>
    <div class="p-3">
        <button class="btn btn-primary" type="submit">
            Enviar
        </button>
    </div>
</form>
