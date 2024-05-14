<div class="{{ $classes ?? null }}">
    <label for="{{ $identificador }}" class="form-label">
        {{ $titulo }}
        @if (isset($mandatory) && $mandatory == 'true')
            <strong class="text-danger star">
                <i class="fa fa-asterisk"></i>
            </strong>
        @endif
    </label>

    <input autocomplete="on" type="{{ $tipo }}" name="{{ $identificador }}" id="{{ $identificador }}"
        placeholder="{{ $placeholder ?? null }}" value="{{ $valor ?? old($identificador) }}"
        class="form-control @error($identificador) is-invalid @enderror {{ $mascara ?? null }}">

    @error($identificador)
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <small class="d-block">
        {{ $description ?? null }}
    </small>
</div>
