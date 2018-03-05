@extends('layouts.form')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.log_in')
        @endslot
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            @include('partials.form-group', [
                'title' => __('Identifiant'),
                'type' => 'text',
                'name' => 'username',
                'readonly' => false,
                'required' => true,
                'autofocus' => 'true',
                ])
            @include('partials.form-group', [
                'title' => __('Mot de passe'),
                'type' => 'password',
                'name' => 'password',
                'readonly' => false,
                'required' => true,
                'autofocus' => '',
                ])
            <!-- <div class="form-check"> -->
            <div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
				<label class="custom-control-label" for="remember"> @lang('validation.custom.remember_me')</label>
            	@component('components.button')
                	@lang('validation.custom.log_in')
            	@endcomponent
            </div>
        </form>
    @endcomponent
@endsection