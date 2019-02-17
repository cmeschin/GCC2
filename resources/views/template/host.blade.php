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
                            @if ( in_array($host['host_id'], $site['selected']))
                                <option value="{{ $site['id'] }}" selected>{{ $site['alias'] }}</option>
                            @else
                                <option value="{{ $site['id'] }}">{{ $site['alias'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has("host-site" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-site" . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="host-type{{ $numHost }}">Type</label>
                <div class="form-control">
                    <select id="host-type{{ $numHost }}" name="host-type{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-type" . $numHost .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($hostTypes as $hostType)
                            @if ( in_array($host['host_id'], $hostType['selected']))
                                <option value="{{ $hostType['id'] }}" selected>{{ $hostType['alias'] }}</option>
                            @else
                                <option value="{{ $hostType['id'] }}">{{ $hostType['alias'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has("host-type" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-type" . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="host-name{{ $numHost }}">Nom</label>
                <input id="host-name{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-name" . $numHost) ? ' is-invalid' : '' }}" name="host-name{{ $numHost }}" placeholder="Nom de l'hôte" value="{{ old("host-name" . $numHost, isset($host['host_name']) ? $host['host_name'] : '') }}" required="required" readonly="readonly">
                @if ($errors->has("host-name" . $numHost))
                    <div class="invalid-feedback">
                        {{ $errors->first("host-name" . $numHost) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="host-address{{ $numHost }}">Adresse IP</label>
                <input id="host-address{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-address" . $numHost) ? ' is-invalid' : '' }}" name="host-address{{ $numHost }}" placeholder="Adresse IP valide" value="{{ old("host-address" . $numHost, isset($host['host_address']) ? $host['host_address'] : '') }}" required="required">
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
            <div class="form-group">
                <label for="host-description{{ $numHost }}">Description</label>
                <textarea id="host-description{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-description" . $numHost) ? ' is-invalid' : '' }}" name="host-description{{ $numHost }}" rows="4" placeholder="description succinte de l'hôte" value="{{ old("host-description" . $numHost, isset($host['host_alias']) ? $host['host_alias'] : '') }}" required="required"></textarea>
                @if ($errors->has("host-description" . $numHost))
                    <div class="invalid-feedback">
                        {{ $errors->first("host-description" . $numHost) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="host-os{{ $numHost }}">OS</label>
                <div class="form-control">
                    <select id="host-os{{ $numHost }}" name="host-os{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-os" . $numHost .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($hostOss as $hostOs)
                            @if ( in_array($host['host_id'], $hostOs['selected']))
                                <option value="{{ $hostOs['id'] }}" selected>{{ $hostOs['alias'] }}</option>
                            @else
                                <option value="{{ $hostOs['id'] }}">{{ $hostOs['alias'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has("host-os" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-os" . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="host-solution{{ $numHost }}">Solution</label>
                <div class="form-control">
                    <select id="host-solution{{ $numHost }}" name="host-solution{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-solution" . $numHost .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($solutions as $solution)
                            @if ( in_array($host['host_id'], $solution['selected']))
                                <option value="{{ $solution['id'] }}" selected>{{ $solution['alias'] }}</option>
                            @else
                                <option value="{{ $solution['id'] }}">{{ $solution['alias'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has("host-solution" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-solution" . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="host-fonction{{ $numHost }}">Fonctions</label>
                <div class="form-control">
                    <select id="host-fonction{{ $numHost }}" name="host-fonction{{ $numHost }}[]" class="select2 form-control{{ $errors->has( "host-fonction" . $numHost .'[]') ? ' is-invalid' : ''}}" required multiple="multiple" style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($hostFonctions as $hostFonction)
                            @if ( in_array($host['host_id'], $hostFonction['selected']))
                                <option value="{{ $hostFonction['id'] }}" selected>{{ $hostFonction['alias'] }}</option>
                            @else
                                <option value="{{ $hostFonction['id'] }}">{{ $hostFonction['alias'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has("host-fonction" . $numHost ))
                        <div class="invalid-feedback">
                            {{ $errors->first("host-fonction" . $numHost) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="host-consigne{{ $numHost }}">Consigne</label>
                <input id="host-consigne{{ $numHost }}" type="text" class="form-control{{ $errors->has("host-consigne" . $numHost) ? ' is-invalid' : '' }}" name="host-consigne{{ $numHost }}" placeholder="Consigne à appliquer en cas d'alerte" value="{{ old("host-consigne" . $numHost, isset($host['ehi_notes_url']) ? $host['ehi_notes_url'] : '') }}" required="required">
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
        // $(document).ready(function() {
            $('.select2').select2();
        // });
    </script>
@endsection