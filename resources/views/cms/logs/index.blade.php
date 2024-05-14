<x-cms-layout>
    <x-cms.partials.forms.card>
        <x-cms.partials.forms.title titulo="{{ $title }}" classes="col-md-6" />
        <x-generator.input id="search-input" tipo="text" titulo="Pesquisar" size="4" placeholder="Buscar..." />

        <div class="list text-center mt-2">
            <div id="tabulator-table"></div>
        </div>
    </x-cms.partials.forms.card>

    @section('other-scripts')
        <script>
            generateTable('api/logs', [], false);
        </script>
    @endsection
</x-cms-layout>
