{{-- @dd($dados) --}}
<div class="{{ $classes ?? null }}">
    <label for="{{ $identificador }}">{{ $titulo }}</label>

    <select name="{{ $identificador }}" id="{{ $identificador }}"
        class="form-select @error($identificador) is-invalid @enderror {{ $mascara ?? null }}">
        <option value="0">Selecione</option>
        @if (isset($dados))
            @foreach ($dados as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>

    @error($identificador)
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <small class="d-block">
        {{ $description ?? null }}
    </small>
</div>
