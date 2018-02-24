@extends('layouts.app')

@section('menu')
   	<div class="navbar-header">
        <ul class="nav navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDemandes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Demandes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownDemandes">
                    <a class="dropdown-item" href="/new">@lang('validation.custom.new_request')</a>
                    <a class="dropdown-item" href="#">@lang('validation.custom.pending_requests')</a>
                    <a class="dropdown-item" href="#">@lang('validation.custom.archived_requests')</a>
                </div>
            </li>
            <li class="nav-item"> <a class="nav-link" href="#">@lang('validation.custom.benefits')</a> </li>
            <li class="nav-item disabled"> <a class="nav-link" href="#">@lang('validation.custom.statistics')</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#">@lang('validation.custom.documentation')</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#">@lang('validation.custom.administration')</a> </li>
        </ul>
    </div>
    <form class="form-inline my-2 my-lg-0">
        <input class="mr-sm-2 form-control" type="search" placeholder="Recherche" arial-label="Search">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><span class="glyphicon glyphicon-eye-open"></span>@lang('validation.custom.search')</button>
    </form>
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <div class="card ">
                <div class="card-header">Bienvenue {{ Auth::user()->name }}.</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                           {{ session('status') }}
                        </div>
                    @endif
						<div >
							<p>Nous sommes le {{ date("d/m/Y H:i:s") }}.</p>
							<p>Veuillez choisir une action dans le menu ci-dessus.</p>
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@endsection
