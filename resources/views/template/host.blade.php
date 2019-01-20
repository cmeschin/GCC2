@component('components.card')
    @slot('title')
        {{ $host['host_name'] . " / " . $host['host_address'] }}
    @endslot
    <div class="row">
        <div class="col-md-3">
            @include('partials.form-group-select', [
                'title' => __('Site'),
                'type' => 'select',
                'name' => 'host-site',
                'values' => $sites,
                'multiple' => '',
                ])
        </div>
        <div class="col-md-3">
            @include('partials.form-group-select', [
                'title' => __('Type'),
                'type' => 'select',
                'name' => 'host-type',
                'values' => $hostTypes,
                'multiple' => '',
                ])
        </div>
        <div class="col-md-4">
            @include('partials.form-group-input', [
                'title' => __('Nom'),
                'type' => 'text',
                'name' => 'host-name',
                'value' => $host['host_name'],
                'placeholder' => "HOST-NAME",
                'required' => true,
                'readonly' => false,
                ])
        </div>
        <div class="col-md-2">
            @include('partials.form-group-input', [
                'title' => __('Adresse IP'),
                'type' => 'text',
                'name' => 'host_address',
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
                'name' => 'host-description',
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
                'name' => 'host-os',
                'values' => $hostOss,
                'multiple' => '',
                ])
        </div>
        <div class="col-md-3">
            @include('partials.form-group-select', [
                'title' => __('Solution logicielle'),
                'type' => 'select',
                'name' => 'host-solution',
                'values' => $solutions,
                'multiple' => '',
                ])
        </div>
        <div class="col-md-3">
            @include('partials.form-group-select', [
                'title' => __('Fonction(s)'),
                'type' => 'select',
                'name' => 'host-fonction',
                'values' => $hostFonctions,
                'multiple' => 'multiple',
                ])
        </div>
        <div class="col-md-8">
            @include('partials.form-group-input', [
                'title' => __('Consigne'),
                'type' => 'text',
                'name' => 'host-consigne',
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