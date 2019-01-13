@extends('layouts.form_account')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.myaccount') : {{ Auth::user()->name }}
        @endslot
            <div class="row">
            	<div class="col-md-5">
                @include('partials.form-group-input', [
                    'title' => __('Identifiant'),
                    'type' => 'text',
                    'name' => 'username',
                    'value' => Auth::user()->username,
                    'placeholder' => "Identifiant",
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
            	<div class="col-md-5">
                @include('partials.form-group-input', [
                    'title' => __('Email'),
                    'type' => 'text',
                    'name' => 'email',
                    'value' => Auth::user()->email,
                    'placeholder' => "adresse mail",
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
                <div class="col-md-2">
                @include('partials.form-group-input', [
                    'title' => __('Profil'),
                    'type' => 'text',
                    'name' => 'profil',
                    'value' => Auth::user()->role,
                    'placeholder' => "profil utilisateur",
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
			</div>
			<div class='row'>
				<div class="col-md-12 table-responsive">
					<table class="table ">
                        <thead class="text-center">
                            <tr>
                                <th>Type</th>
                                <th>Nom</th>
                                <th>Valeur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                             @foreach($allpreferences as $preference)
                              <tr>
                                  <form method="POST" action="{{ route('delpreference', ['userid' => Auth::user()->id, 'preferenceid' => $preference->id]) }}">
           							{{ csrf_field() }}
	                                  <td> {{$preference->type}} </td>
    	                              <td> {{$preference->cle}} </td>
        	                          <td> {{$preference->valeur}} </td>
            	                      <td>@component('components.button')
                						<span class="fas fa-trash color-tessi-fonce"></span>
            						  @endcomponent</td>
                				  </form>
            	                  
                              </tr>
                             @endforeach
                       </tbody>
                    </table>
				</div>
			</div>
			<div class='card bg-dark'>
				<h4 class="card-header">
        			Nouvel élément
    			</h4>
	    		<div class="card-body">
			        <form method="POST" action="{{ route('addpreference',['userid' => Auth::user()->id]) }}">
           				{{ csrf_field() }}
	                    <div class="row">
	                    <div class="col-md-3">
                            <label for="typepreference">Type</label>
                            <div class="form-control">
                                <select id="typepreference" name="typepreference[]" class="select2 form-control{{ $errors->has('typepreference[]') ? ' is-invalid' : ''}}" required>
        							@foreach($typepreferences as $option)
        	 							<option value="{{ $option['type'] }}">{{ $option['type'] }}</option>
        	 						@endforeach
                                </select>
        						
                                @if ($errors->has('typepreference[]'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('typepreference[]') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            @include('partials.form-group-input', [
                                'title' => __('Nom'),
                                'type' => 'text',
                                'name' => 'cle',
                                'value' => "",
                                'placeholder' => "Nom de l'élément",
                                'required' => true,
                                'readonly' => false,
                                ])
                        </div>
                        <div class="col-md-12">
                            @include('partials.form-group-input', [
                                'title' => __('Valeur'),
                                'type' => 'text',
                                'name' => 'valeur',
                                'value' => "",
                                'placeholder' => "valeurs de l'élément. séparer les mails par un point-virgule <;>",
                                'required' => true,
                                'readonly' => false,
                                ])
                        </div>
                        </div>
                        @component('components.button')
                			<span class="fas fa-plus color-tessi-fonce"> @lang('validation.custom.add')</span>
            			@endcomponent
                	</form>
                </div>
			</div>
        @component('components.button-home')
        @endcomponent
    @endcomponent
@endsection

@section('script')
	<script>
		$('.select2').select2();
		var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
		$.fn.bootstrapDP = datepicker;                 // give $().bootstrapDP the bootstrap-datepicker functionality
		$("#dateactivation").bootstrapDP({
    		daysOfWeekDisabled: "0,6",
    		autoclose: true,
    		language: "fr",
    	    startDate: '0d',
		    calendarWeeks: true,
			todayHighlight: true,
		});
    </script>
@endsection