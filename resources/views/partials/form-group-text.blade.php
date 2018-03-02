<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <textarea id="{{ $name }}" type="{{ $type }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" value="{{ old($name, isset($value) ? $value : '') }}" {{ $required ? 'required' : ''}} {{ $readonly ? 'readonly' : ''}}></textarea>
    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>