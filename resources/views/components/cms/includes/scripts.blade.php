@vite(['resources/js/app.js'])

<script src="{{ asset('modules/jquery/jquery.min.js') }}" defer></script>
<script src="{{ asset('modules/summernote/summernote-lite.min.js') }}" defer></script>
<script src="{{ asset('modules/summernote/summernote-pt-BR.js') }}" defer></script>
<script src="{{ asset('modules/toarst/toastr.min.js') }}" defer></script>
<script src="{{ url('modules/dropzone/dropzone-min.js') }}"></script>
<script src="{{ url('modules/select2/select2.min.js') }}" defer></script>
<script src="{{ url('modules/cropper/cropper.min.js') }}" defer></script>

<script src="{{ url('js/exec.js') }}"></script>
<script src="{{ url('js/functions.js') }}"></script>
<script src="{{ url('js/table.js') }}"></script>
<script src="{{ url('js/componentes/galery.js') }}"></script>

@yield('other-scripts')
