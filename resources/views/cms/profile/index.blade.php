<x-cms-layout>
    <x-cms.partials.forms.card>
        <x-cms.partials.forms.title titulo="Usuários" classes="col-md-6">

            <div class="col-md-6 text-end">
                @can('create_usuarios')
                    <a href="{{ route('usuarios.create') }}" class="btn btn-success">
                        Cadastrar usuário
                    </a>
                @endcan

                @can('read_cargos')
                    <a href="{{ route('cargos.index') }}" class="btn btn-primary text-white">
                        Gerenciar cargos
                    </a>
                @endcan
            </div>

            <x-generator.input id="search-input" tipo="text" titulo="Pesquisar" size="4" placeholder="Buscar..." />

        </x-cms.partials.forms.title>

        <div class="list text-center mt-2">
            <div id="tabulator-table"></div>
        </div>
    </x-cms.partials.forms.card>

    @section('other-scripts')
        <script>
            generateTable('api/users');
        </script>
    @endsection
</x-cms-layout>
