<div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="{{ $id ?? '' }}" name="{{ $id ?? '' }}" value="1" @if($check == 1) checked @endisset>
    <label class="custom-control-label" for="{{ $id ?? ''  }}"> </label>
</div>
