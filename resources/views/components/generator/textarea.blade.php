<div class="col-md-{{ $size }} mt-2">
    <label for="{{ $id }}" class="@error($id) text-danger font-weight-bold @enderror">
        {{ $titulo }}
        @if (isset($mandatory) && $mandatory == 'true')
            <strong class="text-danger star">
                <i  fa-asterisk"></i>
            </strong>
        @endif
    </label>

    <textarea id="{{ $id }}" name="{{ $id }}"
        rows="@if(isset($rows)) {{ $rows }} @else 10 @endif"
        @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
        class="summernote form-control @isset($classes) {{ $classes }} @endisset @error($id) is-invalid @enderror">@if(isset($dados) && !empty($dados)) {!! $dados !!} @else {{ old($id) }} @endif</textarea>

    @error($id)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
