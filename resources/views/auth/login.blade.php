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
                ])
            @include('partials.form-group', [
                'title' => __('Mot de passe'),
                'type' => 'password',
                'name' => 'password',
                'readonly' => false,
                'required' => true,
                ])
            <div class="form-check">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">@lang('validation.custom.remember_me')</span>
                </label>
            </div>
            @component('components.button')
                @lang('validation.custom.log_in')
            @endcomponent
        </form>
    @endcomponent
@endsection