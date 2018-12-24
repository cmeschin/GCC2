<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <div class="form-control">
        <select id="{{ $name }}" name="{{ $name }}[]" class="select2 form-control{{ $errors->has( $name .'[]') ? ' is-invalid' : ''}}" required style="width: 100%">
            <option value="" selected>...</option>
            @foreach($values as $value)
                <option value="{{ $value['id'] }}">{{ $value['alias'] }}</option>
            @endforeach
        </select>
        @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
        @endif
    </div>
</div>