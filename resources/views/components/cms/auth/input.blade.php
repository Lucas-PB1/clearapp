<div class="form-floating">
    <input type="{{ $type }}"
        class="form-control @error($id) is-invalid @enderror @isset($classes) {{ $classes }} @endisset"
        id="{{ $id }}" placeholder="{{ $placeholder }}" value="{{ old($id) }}" name="{{ $id }}">
    <label for="{{ $id }}">{{ $titulo }}</label>
    @error($id)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
