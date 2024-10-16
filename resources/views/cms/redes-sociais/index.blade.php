<x-cms-layout>
    <x-cms.partials.forms.card>
        <x-cms.partials.forms.title titulo="Lista de {{ $title }}" classes="col-md-6">
            @can('create_redes_sociais')
                <a href="{{ route('redes-sociais.create') }}" class="col-md-6 text-end">
                    <button class="btn btn-primary">Cadastrar {{ $title }}</button>
                </a>
            @endcan

            <x-generator.input id="search-input" tipo="text" titulo="Pesquisar" size="4" placeholder="Buscar..." />

        </x-cms.partials.forms.title>

        <div class="list text-center mt-2">
            <div id="tabulator-table"></div>
        </div>
    </x-cms.partials.forms.card>

    @section('other-scripts')
        <script>
            generateTable('api/redes-sociais');
        </script>
    @endsection
</x-cms-layout>
