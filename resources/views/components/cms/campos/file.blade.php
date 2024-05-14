<div class="{{ $classes ?? null }}">
    <label for="{{ $identificador }}">{{ $titulo }}</label>

    <div class="mb-2" style="">
        <img
            src="{{ $valor }}"
            alt="{{ $titulo }}"
            style="height: 70px; border: #aaaaaa  dashed 1px">
    </div>

    <input
        type="file"
        id="{{ $identificador }}"
        name="{{ $identificador }}"
        class="form-control @error($identificador) is-invalid @enderror" >

    @error($identificador)
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <small class="d-block">
        {{ $description ?? null }}
    </small>
</div>
