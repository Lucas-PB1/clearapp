<div class="col-md-{{ $size }} mt-2">
    <label for="{{ $id }}" class="form-label">
        {{ $titulo }}
        @isset($mandatory)
            <strong class="text-danger star">
                <i class="fa fa-asterisk"></i>
            </strong>
        @endisset
    </label>

    <div class="form-control-wrap">
        <select id="{{ $id }}" name="{{ $id }}" data-search="on"
            class="form-select js-select2 @error($id) is-invalid @enderror {{ $mascara ?? null }} @isset($mandatory) mandatory @endisset">
            <option value="0">Selecione</option>
            {{ $slot }}
        </select>
    </div>

    @error($id)
        <span>{{ $message }}</span>
    @enderror
</div>
