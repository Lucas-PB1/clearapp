@php
    $edit = isset($dados);
    $check = $tipo == 'checkbox';
    $date = $tipo == 'date';
    $file = $tipo == 'file';
@endphp

<div class="col-md-{{ $size }} mt-2 {{ $classesDiv ?? '' }}">

    {{-- Label --}}
    <label for="{{ $id }}"
        class="{{ $check ? 'form-check-label' : 'form-label' }} @error($id) text-danger font-weight-bold @enderror">
        {{ $titulo }}
        @isset($mandatory)
            <strong class="text-danger star">
                <i class="fa fa-asterisk"></i>
            </strong>
        @endisset
    </label>

    {{--  Image Preview --}}
    @if ($file && $dados)
        <div>
            <img src="{{ $dados->path }}" alt="{{ $dados->desc }}" title="{{ $dados->title }}" style="height: 80px" class="bg-secondary m-2">
        </div>
    @endif

    <div class="{{ isset($linkRoute) ? 'input-group' : 'form-control-wrap'}}">

        {{-- Prepend --}}
        @isset($prepend)
            <div class="input-group-prepend">
                <span class="input-group-text">{{ $prepend }}</span>
            </div>
        @endisset

        {{-- Input --}}
        <input type="{{ !isset($tipo) || $date ? 'text' : $tipo }}" id="{{ $id }}"
            name="{{ $id }}" placeholder="{{ $placeholder ?? '' }}"
            value="{{ $check ? 1 : (!empty($dados) ? $dados : old($id)) }}"
            class="{{ $check ? 'form-check-input' : 'form-control' }} {{ $classes ?? '' }} @error($id) is-invalid @enderror {{ $date ? 'brData date-picker' : '' }}"
            @if ($check && isset($dados) && $dados == true) checked @endisset @isset($mandatory) required @endisset
        @isset($maxlength) maxlength="{{ $maxlength }}" @endisset>

        {{-- Link Button --}}
        @isset($linkRoute)
            <div class="input-group-append">
                <a href="{{ $linkRoute }}" target="_blank" class="btn btn-outline-secondary">Link</a>
            </div>
        @endisset
    </div>

    {{-- Error Message --}}
    @error($id)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
