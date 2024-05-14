<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-portal.includes.metatags />
    <title>{{ config('app.name', 'Jardim De Momentos') }}</title>
    <x-portal.includes.styles />
</head>

<body class="bg-portal">
    <div class="container">
        <h1 class="text-center text-default-color">
            <a href="{{ route('home.index') }}" class="h1 text-decoration-none"> {{ $title ?? 'Jardim de Momentos' }} </a>
        </h1>
        {{ $slot }}
        @if($mainPage)
            <x-portal.layout.footer />
        @endif
    </div>

    <x-portal.includes.scripts />
</body>

</html>
