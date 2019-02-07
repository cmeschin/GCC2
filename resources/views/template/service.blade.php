@component('components.card')
    @slot('title')
        {{ $service['host name'] . " - " . $service['host address'] . " / " . $service['service description']}}
    @endslot
    <div class="row">
        <div class="col-md-9">
            {{--@include('partials.form-group-input', [--}}
                {{--'title' => __('Service'),--}}
                {{--'type' => 'input',--}}
                {{--'name' => 'service-name',--}}
                {{--'value' => $service['service description'],--}}
                {{--'placeholder' => "Nom du service",--}}
                {{--'required' => true,--}}
                {{--'readonly' => true,--}}
                {{--])--}}
            <div class="form-group">
                <label for="service-name{{ $numService }}">Service</label>
                <input id="service-name{{ $numService }}" type="text" class="form-control{{ $errors->has("service-name" . $numService) ? ' is-invalid' : '' }}" name="service-name{{ $numService }}" placeholder="Nom du service" value="{{ old("service-name" . $numService, isset($value) ? $value : '') }}" required="required" readonly="readonly">
                @if ($errors->has("service-name" . $numService))
                    <div class="invalid-feedback">
                        {{ $errors->first("service-name" . $numService) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            {{--@include('partials.form-group-select', [--}}
                {{--'title' => __('Hôte'),--}}
                {{--'type' => 'select',--}}
                {{--'name' => 'service-hostname',--}}
                {{--'values' => $hosts,--}}
                {{--'multiple' => '',--}}
                {{--])--}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            {{--@include('partials.form-group-select', [--}}
                {{--'title' => __('Période de contrôle'),--}}
                {{--'type' => 'select',--}}
                {{--'name' => 'service-timeperiod',--}}
                {{--'values' => $timeperiods,--}}
                {{--'multiple' => '',--}}
                {{--])--}}
        </div>
        <div class="col-md-3">
            {{--@include('partials.form-group-input', [--}}
                {{--'title' => __('Modèle'),--}}
                {{--'type' => 'text',--}}
                {{--'name' => 'service-template',--}}
                {{--'value' => $service['service template description'],--}}
                {{--'placeholder' => "Modèle de service",--}}
                {{--'required' => true,--}}
                {{--'readonly' => false,--}}
                {{--])--}}
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="row">

    </div>
@endcomponent
@section('script')
    <script>
        {{--// $(document).ready(function() {--}}
        // $('.select2').select2();
        {{--// });--}}
    </script>
@endsection