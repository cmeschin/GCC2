@component('components.card')
    @slot('title')
        {{ $numHost . " - " . $host['host_name'] . " / " . $host['host_address'] }}
    @endslot
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="host-site{{ $numHost }}">Site</label>
                <div class="form-control">
                    <select id="host-site{{ $numHost }}" name="host-site{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-site" . $numHost .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($sites as $site)
                            <option value="{{ $site['id'] }}">{{ $site['alias'] }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("host-site" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-site . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            {{--@include('partials.form-group-select', [--}}
                {{--'title' => __('Type'),--}}
                {{--'type' => 'select',--}}
                {{--'name' => 'host-type',--}}
                {{--'values' => $hostTypes,--}}
                {{--'multiple' => '',--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-type{{ $numHost }}">Type</label>
                <div class="form-control">
                    <select id="host-type{{ $numHost }}" name="host-type{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-type" . $numHost .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($hostTypes as $hostType)
                            <option value="{{ $hostType['id'] }}">{{ $hostType['alias'] }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("host-type" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-type . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{--@include('partials.form-group-input', [--}}
                {{--'title' => __('Nom'),--}}
                {{--'type' => 'text',--}}
                {{--'name' => 'host-name',--}}
                {{--'value' => $host['host_name'],--}}
                {{--'placeholder' => "HOST-NAME",--}}
                {{--'required' => true,--}}
                {{--'readonly' => false,--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-name{{ $numHost }}">Nom</label>
                <input id="host-name{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-name" . $numHost) ? ' is-invalid' : '' }}" name="host-name{{ $numHost }}" placeholder="Nom de l'hôte" value="{{ old("host-name" . $numHost, isset($value) ? $value : '') }}" required="required">
                @if ($errors->has("host-name" . $numHost))
                    <div class="invalid-feedback">
                        {{ $errors->first("host-name" . $numHost) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            {{--@include('partials.form-group-input', [--}}
                {{--'title' => __('Adresse IP'),--}}
                {{--'type' => 'text',--}}
                {{--'name' => 'host-address',--}}
                {{--'value' => $host['host_address'],--}}
                {{--'placeholder' => "HOST-IP",--}}
                {{--'required' => true,--}}
                {{--'readonly' => false,--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-address{{ $numHost }}">Adresse IP</label>
                <input id="host-address{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-address" . $numHost) ? ' is-invalid' : '' }}" name="host-address{{ $numHost }}" placeholder="Adresse IP valide" value="{{ old("host-address" . $numHost, isset($value) ? $value : '') }}" required="required">
                @if ($errors->has("host-address" . $numHost))
                    <div class="invalid-feedback">
                        {{ $errors->first("host-address" . $numHost) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            {{--@include('partials.form-group-text', [--}}
                {{--'title' => __('Description'),--}}
                {{--'type' => 'text',--}}
                {{--'rows' => 4,--}}
                {{--'name' => 'host-description',--}}
                {{--'value' => $host['host_alias'],--}}
                {{--'placeholder' => "short description of host",--}}
                {{--'required' => true,--}}
                {{--'readonly' => false,--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-description{{ $numHost }}">Description</label>
                <textarea id="host-description{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-description" . $numHost) ? ' is-invalid' : '' }}" name="host-description{{ $numHost }}" rows="4" placeholder="description succinte de l'hôte" value="{{ old("host-description" . $numHost, isset($value) ? $value : '') }}" required="required"></textarea>
                @if ($errors->has("host-description" . $numHost))
                    <div class="invalid-feedback">
                        {{ $errors->first("host-description" . $numHost) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            {{--@include('partials.form-group-select', [--}}
                {{--'title' => __('OS'),--}}
                {{--'type' => 'select',--}}
                {{--'name' => 'host-os',--}}
                {{--'values' => $hostOss,--}}
                {{--'multiple' => '',--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-os{{ $numHost }}">OS</label>
                <div class="form-control">
                    <select id="host-os{{ $numHost }}" name="host-os{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-os" . $numHost .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($hostOss as $hostOs)
                            <option value="{{ $hostOs['id'] }}">{{ $hostOs['alias'] }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("host-os" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-os . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            {{--@include('partials.form-group-select', [--}}
                {{--'title' => __('Solution logicielle'),--}}
                {{--'type' => 'select',--}}
                {{--'name' => 'host-solution',--}}
                {{--'values' => $solutions,--}}
                {{--'multiple' => '',--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-solution{{ $numHost }}">Solution</label>
                <div class="form-control">
                    <select id="host-solution{{ $numHost }}" name="host-solution{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-solution" . $numHost .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($solutions as $solution)
                            <option value="{{ $solution['id'] }}">{{ $solution['alias'] }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("host-solution" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-solution . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            {{--@include('partials.form-group-select', [--}}
                {{--'title' => __('Fonction(s)'),--}}
                {{--'type' => 'select',--}}
                {{--'name' => 'host-fonction',--}}
                {{--'values' => $hostFonctions,--}}
                {{--'multiple' => 'multiple',--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-fonction{{ $numHost }}">Fonctions</label>
                <div class="form-control">
                    <select id="host-fonction{{ $numHost }}" name="host-fonction{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-fonction" . $numHost .'[]') ? ' is-invalid' : ''}}" required multiple="multiple" style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($hostFonctions as $hostFonction)
                            <option value="{{ $hostFonction['id'] }}">{{ $hostFonction['alias'] }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("host-fonction" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-fonction . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {{--@include('partials.form-group-input', [--}}
                {{--'title' => __('Consigne'),--}}
                {{--'type' => 'text',--}}
                {{--'name' => 'host-consigne',--}}
                {{--'value' => $host['ehi_notes_url'],--}}
                {{--'placeholder' => "consigne wiki",--}}
                {{--'required' => true,--}}
                {{--'readonly' => false,--}}
                {{--])--}}
            <div class="form-group">
                <label for="host-consigne{{ $numHost }}">Consigne</label>
                <input id="host-consigne{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-consigne" . $numHost) ? ' is-invalid' : '' }}" name="host-consigne{{ $numHost }}" placeholder="Consigne à appliquer en cas d'alerte" value="{{ old("host-consigne" . $numHost, isset($value) ? $value : '') }}" required="required">
                @if ($errors->has("host-consigne" . $numHost))
                    <div class="invalid-feedback">
                        {{ $errors->first("host-consigne" . $numHost) }}
                    </div>
                @endif
            </div>
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