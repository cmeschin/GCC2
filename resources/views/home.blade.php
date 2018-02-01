@extends('layouts.app')

@section('menu')
    {{--<nav class="navbar" role="navigation">--}}
    	<div class="navbar-header">
        <ul class="nav navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDemandes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Demandes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownDemandes">
                    <a class="dropdown-item" href="#">Nouvelle demande</a>
                    <a class="dropdown-item" href="#">Demandes en cours</a>
                    <a class="dropdown-item" href="#">Demandes archivées</a>
                </div>
            </li>
            <li class="nav-item"> <a class="nav-link" href="#">Prestations</a> </li>
            <li class="nav-item disabled"> <a class="nav-link" href="#">Statistiques</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#">Documentation</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#">Administration</a> </li>
        </ul>
    </div>
    <form class="form-inline my-2 my-lg-0">
        <input class="mr-sm-2 form-control" type="search" placeholder="Recherche" arial-label="Search">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><span class="glyphicon glyphicon-eye-open"></span> Chercher</button>
    </form>
	{{--</nav>--}}
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 alert-info">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenue!</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
						<div class="panel panel-default bg-info">
							{{ Auth::user()->name }} You are logged in!
						</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-md-offset-5 alert-warning">
            <div class="panel panel-default pull-right">
                <div class="panel-heading">Bienvenue!</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
						<div class="panel panel-default bg-info">
							{{ Auth::user()->name }} You are logged in!
						</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-4 alert-danger">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenue 2!</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
						<div class="panel panel-default bg-info">
							{{ Auth::user()->name }} You are logged in!
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
