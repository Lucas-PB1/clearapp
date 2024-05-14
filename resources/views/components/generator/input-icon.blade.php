@props(['icons', 'size' => '6', 'mandatory' => false, 'id' => '', 'titulo'])

<div class="col-md-{{ $size }} mt-2">
    <div class="form-control-wrap">
        <label for="{{ $id }}">
            {{ $titulo }}
            @if ($mandatory)
                <strong class="text-danger star">
                    <i class="fa fa-asterisk"></i>
                </strong>
            @endif
        </label>

        <div class="d-flex mt-2">
            {{-- <div class="input-group-prepend">
                <div class="input-group-text icon-input">
                    <i class="@if (isset($dados)) {{ $dados }} @else fa fa-asterisk @endif"></i>
                </div>
            </div> --}}

            <select id="{{ $id }}" name="{{ $id }}"
                class="form-select js-select2 @error($id) is-invalid @enderror">
                <option>Selecione um ícone</option>
                @foreach ($icons as $icon)
                    <option data-icon="{{ $icon }}" value="{{ $icon }}"
                        @if (isset($dados) && $dados == $icon) selected @endif>
                        {{ $icon }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
