@extends('layouts.form_widget')
@section('card')
    @component('components.card')
        @slot('title')
            Top 10 des dernières demandes
        @endslot
            {{--<div class="row">--}}
                <div class="col-md-12 table-responsive">
                    <table class="table ">
                        <thead class="text-center">
                        <tr>
                            <th>Référence</th>
                            <th>PRestation</th>
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
			{{--</div>--}}

    @endcomponent
@endsection

@section('script')
	<script>
		// $('.select2').select2();
		// var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
		// $.fn.bootstrapDP = datepicker;                 // give $().bootstrapDP the bootstrap-datepicker functionality
		// $("#dateactivation").bootstrapDP({
    	// 	daysOfWeekDisabled: "0,6",
    	// 	autoclose: true,
    	// 	language: "fr",
    	//     startDate: '0d',
		//     calendarWeeks: true,
		// 	todayHighlight: true,
		// });
    </script>
@endsection