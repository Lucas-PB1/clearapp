<x-cms-layout>

    <x-cms.partials.forms.card>
        <x-cms.partials.forms.title titulo="{{ isset($data) ? 'Edição' : 'Cadastro' }} de {{ $title }}" />

        @include('cms.cruds.form')
    </x-cms.partials.forms.card>

    <x-generator.modal.modal />

    @section('other-scripts')
        <script src="{{ url('js/generator/input.js') }}" defer></script>
    @endsection
</x-cms-layout>
