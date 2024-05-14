<form action="{{ route('config.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row ms-0">
        <div class="row">
            @php $logo = getConf($config, 'logo') @endphp
            <x-generator.input :id="$logo->slug" :titulo="$logo->nome" size="6" tipo='file'
                :dados="isset($logo->destaque) ? $logo->destaque : null" />
        </div>

        <div class="row">
            @php $nomeSite = getConf($config, 'nome-do-site') @endphp
            <x-generator.input :id="$nomeSite->slug" :titulo="$nomeSite->nome" size="6" tipo='text'
                dados="{{ isset($nomeSite) ? $nomeSite->{'valor'} : null }}" placeholder="Insira o Nome" />
        </div>
    </div>
    <div class="p-3">
        <button class="btn btn-primary" type="submit">
            Enviar
        </button>
    </div>
</form>
