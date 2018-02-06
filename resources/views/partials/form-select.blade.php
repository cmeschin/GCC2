<div class="">
    <div><label for="{{ $name }}">{{ $title }}</label></div>
    <div class="form-control">
    	{{ Form::select('typedemande', [
           'young' => 'Under 18',
           'adult' => '19 to 30',
           'adult2' => 'Over 30']
    	) }}
	</div>
    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>