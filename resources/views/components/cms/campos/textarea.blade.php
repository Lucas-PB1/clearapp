{{-- @dd($dados) --}}
<div class="{{ $classes ?? null }}">
    <label for="{{ $identificador }}">{{ $titulo }}</label>

    <textarea class="form-control @error($identificador) is-invalid @enderror"
              id="{{ $identificador }}"
              name="{{ $identificador }}"
              placeholder="{{ $placeholder ?? null }}"
              rows="{{ $rows }}">{!! $valor !!}</textarea>

    @error($identificador)
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <small class="d-block">
        {{ $description ?? null }}
    </small>
</div>
