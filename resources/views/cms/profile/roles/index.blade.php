<x-cms-layout>
    <x-cms.partials.forms.card>
        <x-cms.partials.forms.title titulo="Cargos" classes="col-md-6">

            @can('create_cargos')
                <div class="col-md-6 text-end">
                    <a href="{{ route('cargos.create') }}">
                        <button class="btn btn-primary">Cadastrar Cargo</button>
                    </a>
                </div>
            @endcan

            <x-generator.input id="search-input" tipo="text" titulo="Pesquisar" size="4" placeholder="Buscar..." />
        </x-cms.partials.forms.title>

        <div class="list text-center mt-2">
            <div id="tabulator-table"></div>
        </div>
    </x-cms.partials.forms.card>

    @section('other-scripts')
        <script>
            generateTable('api/cargos');
        </script>
    @endsection
</x-cms-layout>
