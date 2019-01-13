@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.general_informations')
        @endslot
        <form id="submitInfosGenerales" method="POST" action="{{ route('selection', $refDemande) }}">
            {{ csrf_field() }}
            <div class="row">
            	<div class="col-md-3">
            	
                @include('partials.form-group-input', [
                    'title' => __('Etat de la demande'),
                    'type' => 'text',
                    'name' => 'etat',
                    'value' => Lang::get('validation.custom.state.draft'),
                    'placeholder' => "etat de la demande",
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
            	<div class="col-md-3">
                @include('partials.form-group-input', [
                    'title' => __('Demandeur'),
                    'type' => 'text',
                    'name' => 'demandeur',
                    'value' => Auth::user()->username,
                    'placeholder' => "identifiant du demandeur",
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
                <div class="col-md-3">
                @include('partials.form-group-input', [
                    'title' => __('Référence de la demande'),
                    'type' => 'text',
                    'name' => 'refDemande',
                    'value' => $refDemande,
                    'placeholder' => "référence de la demande",
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
                <div class="col-md-3">
                @include('partials.form-group-input', [
                    'title' => __('Date de supervision souhaitée'),
                    'type' => 'text',
                    'name' => 'dateActivation',
                    'value' => "",
                    'placeholder' => "jj/mm/aaaa",
                    'required' => true,
                    'readonly' => false,
                    ])
                </div>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <label for="listeDiffusion">Liste de diffusion</label>
                    <div class="form-control">
                        <select id="listeDiffusion" name="listeDiffusion[]" class="select2 form-control{{ $errors->has('listeDiffusion[]') ? ' is-invalid' : ''}}" required>
							<option value="0">{{ Auth::user()->email }}</option>
							@foreach($listDiffusions as $liste)
	 							<option value="{{ $liste['id'] }}">{{ $liste['cle'] . ' - ' . $liste['valeur'] }}</option>
	 						@endforeach
                        </select>
						
                        @if ($errors->has('listeDiffusion[]'))
                            <div class="invalid-feedback">
                                {{ $errors->first('listeDiffusion[]') }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="typeDemande">Type de demande</label>
                    <div class="form-control">
                        <select id="typeDemande" name="typeDemande[]" class="select2 form-control{{ $errors->has('typeDemande[]') ? ' is-invalid' : ''}}" required>
 							<option value="" selected></option>
							@foreach($typeDemandes as $id => $type)
	 							<option value="{{ $id }}">{{ $type }}</option>
	 						@endforeach
                        </select>
						
                        @if ($errors->has('typeDemande[]'))
                            <div class="invalid-feedback">
                                {{ $errors->first('typeDemande[]') }}
                            </div>
                        @endif
                    </div>

                </div>
                <div class="col-md-9">
                    <label for="prestation">Prestation</label>
                    <div class="form-control">
                        <select id="prestation" name="prestation[]" class="select2 form-control{{ $errors->has('prestation[]') ? ' is-invalid' : ''}}" required>
 							<option value="" selected></option>
							@foreach($listPrestations as $prestation)
	 							<option value="{{ $prestation }}">{{ $prestation }}</option>
	 						@endforeach
                        </select>
						
                        @if ($errors->has('prestation[]'))
                            <div class="invalid-feedback">
                                {{ $errors->first('prestation[]') }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('partials.form-group-text', [
                        'title' => __('Description'),
                        'type' => 'text',
                        'name' => 'description',
                        'rows' => "3",
                        'placeholder' => "indiquez ici une brève description de la demande (facultatif)...",
                        'required' => false,
                        'readonly' => false,
                        ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    @component('components.waiting')
                        @lang('pagination.waiting')
                    @endcomponent
                </div>
                <div class="col-md-2">
                    @component('components.button-next')
                    @endcomponent
                </div>
            </div>
        </form>
    @endcomponent
@endsection

@section('script')
	<script>
		$('.select2').select2();
		var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
		$.fn.bootstrapDP = datepicker;                 // give $().bootstrapDP the bootstrap-datepicker functionality
		$("#dateActivation").bootstrapDP({
    		daysOfWeekDisabled: "0,6",
    		autoclose: true,
    		language: "fr",
    	    startDate: '0d',
		    calendarWeeks: true,
			todayHighlight: true
		});
        $("[id^='submit']").submit(function(){ //fonction permettant d'afficher le message d'attente
            waiting();
        });

    </script>
@endsection