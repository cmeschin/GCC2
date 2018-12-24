@component('components.card')
    @slot('title')
        {{ $service['host name'] . " / " . $service['service description'] }}
    @endslot
    <div class="row">
        <div class="col-md-3">
            @include('partials.form-group-select', [
                'title' => __('Site'),
                'type' => 'select',
                'name' => 'hostsite',
                'values' => $sites,
                ])
        </div>
        <div class="col-md-3">
            @include('partials.form-group-select', [
                'title' => __('Type'),
                'type' => 'select',
                'name' => 'hosttype',
                'values' => $hostTypes,
                ])
        </div>
        <div class="col-md-4">
        @include('partials.form-group-input', [
            'title' => __('Nom'),
            'type' => 'text',
            'name' => 'hostname',
            'value' => 'hostname',
            'placeholder' => "HOST-NAME",
            'required' => true,
            'readonly' => false,
            ])
        </div>
        <div class="col-md-2">
            @include('partials.form-group-input', [
                'title' => __('Adresse IP'),
                'type' => 'text',
                'name' => 'hostaddress',
                'value' => 'hostaddress',
                'placeholder' => "HOST-IP",
                'required' => true,
                'readonly' => false,
                ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            @include('partials.form-group-text', [
                'title' => __('Description'),
                'type' => 'text',
                'rows' => 2,
                'name' => 'description',
                'value' => 'host description',
                'placeholder' => "short description of host",
                'required' => true,
                'readonly' => false,
                ])
        </div>
        <div class="col-md-2">
            @include('partials.form-group-select', [
                'title' => __('OS'),
                'type' => 'select',
                'name' => 'hostOss',
                'values' => $hostOss,
                ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            @include('partials.form-group-select', [
                'title' => __('Solution logicielle'),
                'type' => 'select',
                'name' => 'Solution',
                'values' => $solutions,
                ])
        </div>
        <div class="col-md-2">
            @include('partials.form-group-select', [
                'title' => __('Fonction(s)'),
                'type' => 'select',
                'name' => 'hostFonctions',
                'values' => $hostFonctions,
                ])
        </div>

    </div>
@endcomponent
@section('script')
	<script>
		$('.select2').select2();
    </script>
@endsection