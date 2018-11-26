@extends('layouts.form')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.registration') - @lang('validation.custom.first_log_in')
        @endslot
        @slot('slot')
            <div class="alert alert-info">
                Ce formulaire n'apparaitra qu'une seule fois.
                Vérifiez vos informations personnelles issues de l'AD et validez.
            </div>
            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                @include('partials.form-group', [
                    'title' => __('Identifiant'),
                    'type' => 'text',
                    'name' => 'username',
                    'value' => $username,
                    'required' => true,
                    'autofocus' => 'autofocus',
                    ])
                @include('partials.form-group', [
                    'title' => __('Nom'),
                    'type' => 'text',
                    'name' => 'name',
                    'required' => true,
                    'autofocus' => '',
                    ])
                @include('partials.form-group', [
                    'title' => __('Adresse email'),
                    'type' => 'email',
                    'name' => 'email',
                    'required' => true,
                    'autofocus' => '',
                    ])
                {{--@include('partials.form-group', [--}}
                    {{--'title' => __('Mot de passe'),--}}
                    {{--'type' => 'password',--}}
                    {{--'name' => 'password',--}}
                    {{--'required' => true,--}}
                    {{--])--}}
                {{--@include('partials.form-group', [--}}
                    {{--'title' => __('Confirmation du mot de passe'),--}}
                    {{--'type' => 'password',--}}
                    {{--'name' => 'password_confirmation',--}}
                    {{--'required' => true,--}}
                    {{--])--}}
                @component('components.button')
                    @lang('Inscription')
                @endcomponent
            </form>
        @endslot
    @endcomponent
@endsection