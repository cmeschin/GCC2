<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <div class="form-control">
        <select id="{{ $name }}" name="{{ $name }}[]" class="select2 form-control{{ $errors->has( $name .'[]') ? ' is-invalid' : ''}}" {{ $multiple }} required style="height: 100%;width: 100%">
            <option value=""></option>
            @foreach($values as $value)
                        <option value="{{ $value[0] }}">{{ $value[1] }}</option>
            @endforeach
        </select>
        @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
        @endif
    </div>
</div>