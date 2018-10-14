@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.parametrage')
        @endslot
        <form method="POST" action="">
            {{ csrf_field() }}
            <div class="row">
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