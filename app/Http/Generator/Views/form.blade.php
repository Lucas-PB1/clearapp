@php $route = !isset($data) ? route('<nome-do-crud>.store') : route('<nome-do-crud>.update', $data->id) @endphp

<form action="{{ $route }}" method="post">
    @csrf

    @isset($data)
        @method('PUT')
    @endisset

    <div class="row ms-0">
        <include-campos>
    </div>
    <div class="p-3">
        <button class="btn btn-primary" type="submit">
            Enviar
        </button>
    </div>
</form>
