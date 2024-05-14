<div class="form-check {{ $classes ?? null }}">
    <input class="form-check-input" id="{{ $identificador }}-0" name="{{ $identificador }}" type="hidden" value="0"
        @if ($valor) checked @endif>

    <input class="form-check-input" id="{{ $identificador }}-1" name="{{ $identificador }}" type="checkbox" value="1"
        @if ($valor) checked @endif>

    <label class="form-check-label fw-bold" for="{{ $identificador }}-1">
        {{ $titulo }}
    </label>

    @error($identificador)
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <small class="d-block">
        {{ $description ?? null }}
    </small>
</div>
