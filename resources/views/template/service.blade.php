@component('components.card')
    @slot('title')
        {{ $service['service description'] . " / " . $service['host name'] . " - " . $service['host address'] }}
    @endslot
    <div class="row">
        <div class="col-md-9">
            @include('partials.form-group-input', [
                'title' => __('Service'),
                'type' => 'input',
                'name' => 'service-name',
                'value' => $service['service description'],
                'placeholder' => "Nom du service",
                'required' => true,
                'readonly' => true,
                ])
        </div>
        <div class="col-md-3">
            @include('partials.form-group-input', [
                'title' => __('Hôte'),
                'type' => 'input',
                'name' => 'service-hostname',
                'value' => $service['host name'],
                'placeholder' => "Nom de l'hôte",
                'required' => true,
                'readonly' => true,
                ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            @include('partials.form-group-select', [
                'title' => __('Période de contrôle'),
                'type' => 'select',
                'name' => 'service-timeperiod',
                'values' => $timeperiods,
                ])
        </div>
        <div class="col-md-2">
            @include('partials.form-group-input', [
                'title' => __('Adresse IP'),
                'type' => 'text',
                'name' => 'hostaddress',
                'value' => $host['host_address'],
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
                'rows' => 4,
                'name' => 'description',
                'value' => $host['host_alias'],
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
        <div class="col-md-3">
            @include('partials.form-group-select', [
                'title' => __('Solution logicielle'),
                'type' => 'select',
                'name' => 'Solution',
                'values' => $solutions,
                ])
        </div>
        <div class="col-md-3">
            @include('partials.form-group-select-multiple', [
                'title' => __('Fonction(s)'),
                'type' => 'select',
                'name' => 'hostFonctions',
                'values' => $hostFonctions,
                ])
        </div>
        <div class="col-md-8">
            @include('partials.form-group-input', [
                'title' => __('Consigne'),
                'type' => 'text',
                'name' => 'consigne',
                'value' => $host['ehi_notes_url'],
                'placeholder' => "consigne wiki",
                'required' => true,
                'readonly' => false,
                ])
        </div>
    </div>
    <div class="row">

    </div>
@endcomponent
@section('script')
    <script>
        {{--// $(document).ready(function() {--}}
        $('.select2').select2();
        {{--// });--}}
    </script>
@endsection