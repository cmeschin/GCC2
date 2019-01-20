<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <div class="form-control">
        <select id="{{ $name }}" name="{{ $name }}[]" class="select2 form-control{{ $errors->has( $name .'[]') ? ' is-invalid' : ''}}" multiple required style="height: 100%;width: 100%">
            <option value="">...</option>
            @foreach($values as $value)
                @if ( in_array($host['host_id'], $value['selected']))
                    <option value="{{ $value['id'] }}" selected>{{ $value['alias'] }}</option>
                @else
                    <option value="{{ $value['id'] }}">{{ $value['alias'] }}</option>
                @endif
            @endforeach

        </select>
        @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
        @endif
    </div>
</div>