<x-cms-layout>
    <x-cms.partials.forms.card>
        <x-cms.partials.forms.title titulo="{{ isset($data) ? 'Editar' : 'Cadastrar' }} Cargo" />

        @include('cms.profile.roles.form')
    </x-cms.partials.forms.card>

    @section('other-scripts')
        <script src="{{ url('js/cms/cargos/index.js') }}"></script>
    @endsection
</x-cms-layout>
