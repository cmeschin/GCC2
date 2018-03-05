<div><label for="{{ $name }}">{{ $title }}</label></div>
<div class="form-control">
    	{{ Form::select($name,$valeur,null,array('class' => "form-control{{ $errors->has($name) ? ' is-invalid' : ''}}",'id' =>  $name, 'required' => $required )) }}
    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>