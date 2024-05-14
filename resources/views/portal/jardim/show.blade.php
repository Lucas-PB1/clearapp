<x-app-layout title="{{ 'Jardim de ' . $data->{'nome-da-galeria'} }}">
    <input id="slug" value="{{ $data->slug }}" type="text" style="display: none">

    <div id="gallery" class="row"></div>
</x-app-layout>
