@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.general_informations')
        @endslot
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="row">
            	<div class="col-md-4">
                @include('partials.form-group-input', [
                    'title' => __('Demandeur'),
                    'type' => 'text',
                    'name' => 'demandeur',
                    'value' => Auth::user()->username,
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
                <div class="col-md-4">
                @include('partials.form-group-input', [
                    'title' => __('Référence de la demande'),
                    'type' => 'text',
                    'name' => 'refdemande',
                    'value' => date("YmdHi") . "_" . Auth::user()->username,
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
                <div class="col-md-4">
                @include('partials.form-group-input', [
                    'title' => __('Date de supervision souhaitée'),
                    'type' => 'date',
                    'name' => 'datedemande',
                    'value' => date("d / m / Y"),
                    'required' => true,
                    'readonly' => false,
                    ])
                </div>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <label for="listeDiffusion">Liste de diffusion</label>
                    <div class="form-control">
                        <select id="listeDiffusion" name="listeDiffusion[]" class="select2 form-control{{ $errors->has('listeDiffusion') ? ' is-invalid' : ''}}" required>
 							<option value="0" selected>{{ Auth::user()->email }}</option>
							@foreach($listdiffusions as $liste)
	 							<option value="{{ $liste['id'] }}">{{ $liste['valeur'] }}</option>
	 						@endforeach
                        </select>
						
                        @if ($errors->has('listeDiffusion'))
                            <div class="invalid-feedback">
                                {{ $errors->first('listeDiffusion') }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="typeDemande">Type de demande</label>
                    <div class="form-control">
                        <select id="typeDemande" name="typeDemande[]" class="select2 form-control{{ $errors->has('typeDemande') ? ' is-invalid' : ''}}" required>
 							<option value="" selected></option>
							@foreach($typedemandes as $id => $type)
	 							<option value="{{ $id }}">{{ $type }}</option>
	 						@endforeach
                        </select>
						
                        @if ($errors->has('typeDemande'))
                            <div class="invalid-feedback">
                                {{ $errors->first('typeDemande') }}
                            </div>
                        @endif
                    </div>

                </div>
                <div class="col-md-9">
                    <label for="prestation">Prestation</label>
                    <div class="form-control">
                        <select id="prestation" name="prestation" class="select2 form-control{{ $errors->has('prestation') ? ' is-invalid' : ''}}" required>
 							<option value="" selected></option>
							@foreach($listprestations as $prestation)
	 							<option value="{{ $prestation['sg_name'] }}">{{ $prestation['sg_name'] }}</option>
	 						@endforeach
                        </select>
						
                        @if ($errors->has('prestation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('prestation') }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
        				<label for="commentaire">Description</label>
        				<textarea id="commentaire" type="text" class="form-control" name="commentaire" rows="3"></textarea>
        				
    				</div>
                </div>
            </div>
            @component('components.button')
                @lang('pagination.next')
            @endcomponent
        </form>
    @endcomponent
@endsection

@section('script')
	<script>
		$('.select2').select2();
    </script>
@endsection