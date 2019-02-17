@component('components.card')
    @slot('title')
        {{ $service['host_name'] . " [" . $service['host_address'] . "] - " . $service['service_description']}}
    @endslot
    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <label for="service-timeperiod{{ $numService }}">Type</label>
                <div class="form-control">
                    <select id="service-timeperiod{{ $numService }}" name="service-timeperiod{{ $numService }}[]" class="select2 form-control{{ $errors->has( "service-timeperiod" . $numService .'[]') ? ' is-invalid' : ''}}" required style="height: 100%;width: 100%">
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
    </div>
@endcomponent
