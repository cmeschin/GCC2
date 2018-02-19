
<div><label for="{{ $name }}">{{ $title }}</label></div>
<div class="form-control">
    	{{ Form::select($name,$valeur,null,array('class' => "select2 form-control {{ $errors->has($name) ? ' is-invalid' : ''",'id' =>  $name )) }}
    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>