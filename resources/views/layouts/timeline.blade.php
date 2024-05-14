<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-cms.includes.metatags />
    <link rel="stylesheet" href="{{ url('modules/font-awesome/font-awesome.min.css') }}">

    @vite(['resources/sass/app.scss'])
    @vite(['resources/less/import-cms.less'])

    @yield('other-styles')

    <link rel="stylesheet" href="{{ url('css/timeline.css') }}">
</head>

<body id="body-pd antialised">
    <div class="wrapper">
        <div id="content">
            {{ $slot }}
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <script src="{{ asset('modules/jquery/jquery.min.js') }}" defer></script>

    <script src="{{ url('js/exec.js') }}"></script>
    <script src="{{ url('js/functions.js') }}"></script>

    @yield('other-scripts')

</body>

</html>
