@extends('layouts.form')

@include('components.menu',[
    'role' => $role,
])

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
