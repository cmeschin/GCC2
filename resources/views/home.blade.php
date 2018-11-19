@extends('layouts.form')

@include('components.menu',[
    'role' => $role,
])

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="offset-md-4 col-md-4">
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
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        {{--<div class="row">--}}
            {{--@include('template.widget')--}}
        {{--</div>--}}

        <div class="card col-md-5 offset-md-1">
            <h4 class="card-header">
                {{ $limit }} dernières demandes rédigées
            </h4>
            <div class="col-md-12 table-responsive">
                <table class="table ">
                    <thead class="text-center">
                    <tr>
                        <th>Référence</th>
                        <th>Prestation</th>
                        <th>Date activation</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($lastrequest as $demande)
                        <tr>
                            <td> {{$demande->reference}} </td>
                            <td> {{$demande->prestation}} </td>
                            <td> {{$demande->date_activation}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-md-5">
            <h4 class="card-header">
                {{ $limit }} dernières demandes traitées
            </h4>
            <div class="col-md-12 table-responsive">
                <table class="table ">
                    <thead class="text-center">
                    <tr>
                        <th>Référence</th>
                        <th>Prestation</th>
                        <th>Date activation</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($lastprocessed as $demande)
                        <tr>
                            <td> {{$demande->reference}} </td>
                            <td> {{$demande->prestation}} </td>
                            <td> {{$demande->date_activation}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <p></p>
    </div>
    <div class="row">
        <div class="card col-md-10 offset-md-1">
            <h4 class="card-header">
                Information - Astuce du jour
            </h4>
            <div class="col-md-12 table-responsive">
                <p>blablabla</p>
            </div>
        </div>

    </div>
</div>

@endsection
