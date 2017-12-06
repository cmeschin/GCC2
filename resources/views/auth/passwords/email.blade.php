@extends('layouts.form')
@section('card')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @component('components.card')
        @slot('title')
            @lang('Gestion des mots de passe')
        @endslot
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <p>Les mots de passe sont gérés par l'AD. Contacter l'EPI-Infra pour vérifier votre compte de domaine TT.</p>
                    <a class="btn btn-primary float-right" href="{{ route('login') }}">
                        @lang('Retour')
                    </a>
            </div>
        </form>
    @endcomponent
@endsection