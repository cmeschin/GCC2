@extends('layouts.form_account')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.accounts_managment')
        @endslot
			<div class='row'>
				<div class="col-md-12 table-responsive">
					<table class="table ">
                        <thead class="text-center">
                            <tr>
                                <th>@lang('validation.custom.login')</th>
                                <th>@lang('validation.custom.fullname')</th>
                                <th>@lang('validation.custom.email')</th>
                                <th>@lang('validation.custom.role')</th>
                                <th>@lang('validation.custom.created_at')</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                             @foreach($allAccounts as $account)
                              <tr>
                                  <td> {{$account->username}} </td>
                                  <td> {{$account->name}} </td>
                                  <td> {{$account->email}} </td>
                                  <td> {{$account->role}} </td>
                                  <td> {{$account->created_at}} </td>
                                  <td>
                                      @if ($account->username != Auth::user()->username)
                                          <form method="POST" action="{{ route('delaccount', ['userid' => $account->id]) }}" onsubmit="return ConfirmDelete()">
                                              {{ csrf_field() }}
                                              @component('components.button')
                                                  <span class="fas fa-trash color-tessi-fonce"></span>
                                              @endcomponent
                                          </form>
                                          <form method="POST" action="{{ route('setaccount', ['userid' => $account->id]) }}">
                                              {{ csrf_field() }}
                                              @component('components.button')
                                                  @if ($account->role == "admin")
                                                      <span class="fas fa-toggle-on color-tessi-fonce"></span>
                                                  @else
                                                      <span class="fas fa-toggle-off color-tessi-fonce"></span>
                                                  @endif
                                              @endcomponent
                                          </form>
                                      @endif
                                  </td>
                              </tr>
                             @endforeach
                       </tbody>
                    </table>
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
        function ConfirmDelete()
        {
            // TODO: faire un bouton plus joli
            var x = confirm("Confirmer la suppression?");
            if (x)
                return true;
            else
                return false;
        }

    </script>
@endsection