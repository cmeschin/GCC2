@component('components.card-without-title')
    {{--@slot('title')--}}
        {{--{{ $numService . " - " . $service['host_name'] . " [" . $service['host_address'] . "] - " . $service['service_description']}}--}}
    {{--@endslot--}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="service-timeperiod{{ $numService }}">Période</label>
                <div class="form-control">
                    <select id="service-timeperiod{{ $numService }}" name="service-timeperiod{{ $numService }}[]"
                            class="select2 form-control{{ $errors->has( "service-timeperiod" . $numService .'[]') ? ' is-invalid' : ''}}"
                            required style="height: 100%;width: 100%">
                        <option value=""></option>
                        @foreach($timeperiods as $timeperiod)
                            @if ( in_array($service['service_id'], $timeperiod['selected']))
                                <option value="{{ $timeperiod['tp_id'] }}" selected>{{ $timeperiod['tp_name'] }}</option>
                            @else
                                <option value="{{ $timeperiod['tp_id'] }}">{{ $timeperiod['tp_name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has("service-timeperiod" . $numService ))
                        <div class="invalid-feedback">
                            {{ $errors->first("service-timeperiod" . $numService) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="service-frequence{{ $numService }}">Fréquence</label>
                <input id="service-frequence{{ $numService }}" type="text" class="form-control{{ $errors->has("service-frequence" . $numService) ? ' is-invalid' : '' }}"
                       name="service-frequence{{ $numService }}" placeholder="fréquence des contrôles"
                       value="{{ old("service-frequence" . $numService, isset($service['service_interval']) ? $service['service_interval'] : 'par défaut') }}"
                       readonly>
                @if ($errors->has("service-frequence" . $numService))
                    <div class="invalid-feedback">
                        {{ $errors->first("service-frequence" . $numService) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="service-etat{{ $numService }}">Etat</label>
                <input id="service-etat{{ $numService }}" type="text" class="form-control{{ $errors->has("service-etat" . $numService) ? ' is-invalid' : '' }}"
                       name="service-etat{{ $numService }}" placeholder="état du service"
                       value="{{ old("service-etat" . $numService, isset($Etat) ? $Etat : 'étrange') }}"
                       readonly>
                @if ($errors->has("service-etat" . $numService))
                    <div class="invalid-feedback">
                        {{ $errors->first("service-etat" . $numService) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="service-param{{ $numService }}">Paramétrage à effectuer</label>
                <div class="form-control">
                    <select id="service-param{{ $numService }}" name="service-param{{ $numService }}[]"
                            class="select2 form-control{{ $errors->has( "service-param" . $numService .'[]') ? ' is-invalid' : ''}}"
                            required style="height: 100%;width: 100% ">
                        @include('components.param-list')
                    </select>
                    @if ($errors->has("service-param" . $numService ))
                        <div class="invalid-feedback">
                            {{ $errors->first("service-param" . $numService) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="service-consigne{{ $numService }}">
                    Consigne
                    @if ($service['esi_notes_url'])
                        {{ "- " }}<a href="{{ $service['esi_notes_url'] }}" target="_blank" role="button" aria-expanded="false" aria-controls="service-consigne{{ $numService}}">
                            Suivre le lien</a>
                    @endif
                </label>
                <input id="service-consigne{{ $numService }}" type="text" class="form-control{{ $errors->has("service-consigne" . $numService) ? ' is-invalid' : '' }}"
                       name="service-consigne{{ $numService }}" placeholder="consigne(s) à appliquer en cas d'alerte."
                       value="{{ old("service-consigne" . $numService, isset($service['esi_notes_url']) ? $service['esi_notes_url'] : '') }}"
                       required="required">

                @if ($errors->has("service-consigne" . $numService))
                    <div class="invalid-feedback">
                        {{ $errors->first("service-consigne" . $numService) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <label for="service-modele{{ $numService }}">Modèle de service</label>
                    <div class="form-control">
                        <select id="service-modele{{ $numService }}" name="service-modele{{ $numService }}[]"
                                class="select2 form-control{{ $errors->has( "service-modele" . $numService .'[]') ? ' is-invalid' : ''}}"
                                required style="height: 100%;width: 100%">
                            <option value=""></option>
                            @foreach($serviceTemplates as $serviceTemplate)
                                @if ( in_array($service['service_id'], $serviceTemplate['selected']))
                                    <option value="{{ $serviceTemplate['id'] }}" selected>{{ $serviceTemplate['description'] }}</option>
                                @else
                                    <option value="{{ $serviceTemplate['id'] }}">{{ $serviceTemplate['description'] }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has("service-modele" . $numService ))
                            <div class="invalid-feedback">
                                {{ $errors->first("service-modele" . $numService) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('template.servicemacros')
                </div>
            </div>
        </div>
    </div>
@endcomponent
