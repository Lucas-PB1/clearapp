<link rel="stylesheet" href="{{ url('modules/summernote/summernote-lite.min.css') }}">
<link rel="stylesheet" href="{{ url('modules/toarst/toastr.css') }}">
<link rel="stylesheet" href="{{ url('modules/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{ url('modules/font-awesome/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ url('modules/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('modules/select2/select2-bootstrap-5-theme.min.css') }}">
<link rel="stylesheet" href="{{ url('modules/cropper/cropper.min.css') }}">

@vite(['resources/sass/app.scss'])
@vite(['resources/less/import-cms.less'])

@yield('other-styles')
