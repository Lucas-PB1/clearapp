<div class="form-group mt-2">
    <label class="form-label" for="roles">Cargos</label>
    <div class="form-control-wrap">
        <div class="form-control-select-multiple">
            <select multiple="" name="roles[]" id="roles" class="form-select">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}"
                        @if(isset($user) && $user->hasRole($role->name)) selected @endif>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
