<div class="form-group inline-form">
    <label for="{{ $name }}">{{ $title }}</label>
    <input id="{{ $name }}" type="{{ $type }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($name, isset($value) ? $value : '') }}" {{ $required ? 'required' : ''}} {{ $readonly ? 'readonly' : ''}}>
    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>