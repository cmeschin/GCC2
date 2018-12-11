@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.parametrage')
        @endslot
        <form id="submitParametrage" method="POST" action="{{ route('validation',$refDemande) }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a class="tessi-rose-clair" role="button" data-toggle="collapse" data-parent="#accordion" href="#listServices"
                                       aria-expanded="true" aria-controls="collapseOne">
                                        @lang('validation.custom.list_of_services')
                                    </a>
                                </h4>
                            </div>
                            <div id="listServices" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body responsive-table-line" style="margin:0 auto">
                                    <table id="T_List_Service" class="table table-bordered table-condensed table-body-center">
                                        <tr class="text-center tessi-rose-clair">
                                            <th>Service</th>
                                            <th>Etat</th>
                                        </tr>
                                        @foreach ($myServices as $service)
                                            <tr>
                                                <td>{{ $service['host name'] . " / " . $service['service description'] }}</td>
                                                <td>état</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed tessi-rose-clair" role="button" data-toggle="collapse" data-parent="#accordion" href="#listHosts"
                                       aria-expanded="false" aria-controls="collapseTwo">
                                        @lang('validation.custom.list_of_hosts')
                                    </a>
                                </h4>
                            </div>
                            <div id="listHosts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    {{--<table id="T_List_Host" class="table table-bordered table-condensed table-body-center">--}}
                                        {{--<tr class="text-center tessi-rose-clair">--}}
                                            {{--<th></th>--}}
                                            {{--<th>Hostname</th>--}}
                                            {{--<th>IP</th>--}}
                                            {{--<th>Description</th>--}}
                                            {{--<th>Contrôle</th>--}}
                                            {{--<th>Site</th>--}}
                                            {{--<th>Solution</th>--}}
                                            {{--<th>Type</th>--}}
                                            {{--<th>Architecture</th>--}}
                                            {{--<th>Fonction</th>--}}
                                            {{--<th>Langue</th>--}}
                                            {{--<th>OS</th>--}}
                                            {{--<th>Type</th>--}}
                                            {{--<th hidden="hidden">host_id</th>--}}
                                        {{--</tr>--}}
                                        {{--@php--}}
                                            {{--$i = 1;--}}
                                        {{--@endphp--}}

                                        {{--@foreach ($hosts as $host)--}}
                                            {{--@if ($host['host_activate'] == 0)--}}
                                                {{--// mise en couleur pour les controles inactifs--}}
                                                {{--<tr class="tessi-disabled">--}}
                                            {{--@else--}}
                                                {{--<tr>--}}
                                                    {{--@endif--}}
                                                    {{--<td class="text-center"><input type="checkbox" name="selection_host[]" id="t{{ $host['host_id'] }}" value="h{{ $host['host_id'] }}"/></td>--}}
                                                    {{--@if ($host['host_activate'] == 1)--}}
                                                        {{--<td><a target="_blank" href="http://192.168.0.22/centreon/main.php?p=20201&o=svcd&host_name={{ $host['host_name'] }}">{{ $host['host_name'] }}</a></td>--}}
                                                    {{--@else--}}
                                                        {{--<td>{{ $host['host_name'] }}</td>--}}
                                                    {{--@endif--}}
                                                    {{--<td>{{ $host['host_address'] }}</td>--}}
                                                    {{--<td>{{ $host['host_alias'] }}</td>--}}
                                                    {{--@if ($host['host_activate'] == 0)--}}
                                                        {{--<td>désactivé</td>--}}
                                                    {{--@else--}}
                                                        {{--<td>actif</td>--}}
                                                    {{--@endif--}}
                                                    {{--<td>{{ $host['GroupeSite'] }}</td>--}}
                                                    {{--<td>{{ $host['GroupeSolution'] }}</td>--}}
                                                    {{--<td>{{ $host['GroupeType'] }}</td>--}}
                                                    {{--<td>{{ $host['CategorieArchitecture'] }}</td>--}}
                                                    {{--<td>{{ $host['CategorieFonction'] }}</td>--}}
                                                    {{--<td>{{ $host['CategorieLangue'] }}</td>--}}
                                                    {{--<td>{{ $host['CategorieOS'] }}</td>--}}
                                                    {{--<td>{{ $host['CategorieType'] }}</td>--}}
                                                    {{--<td>{{ $host['host_id'] }}</td>--}}
                                                {{--</tr>--}}
                                                {{--@php--}}
                                                    {{--$i++;--}}
                                                {{--@endphp--}}
                                                {{--@endforeach--}}
                                    {{--</table>--}}
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed tessi-rose-clair" role="button" data-toggle="collapse" data-parent="#accordion" href="#listTimeperiods"
                                       aria-expanded="false" aria-controls="collapseThree">
                                        @lang('validation.custom.list_of_timeperiods')
                                    </a>
                                </h4>
                            </div>
                            <div id="listTimeperiods" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    {{--<table id="T_List_Timeperiod" class="table table-bordered table-condensed table-body-center">--}}
                                        {{--<tr class="text-center tessi-rose-clair">--}}
                                            {{--<th></th>--}}
                                            {{--<th>@lang('validation.custom.timeperiod')</th>--}}
                                            {{--<th>@lang('validation.custom.weekdays.monday')</th>--}}
                                            {{--<th>@lang('validation.custom.weekdays.tuesday')</th>--}}
                                            {{--<th>@lang('validation.custom.weekdays.wednesday')</th>--}}
                                            {{--<th>@lang('validation.custom.weekdays.thursday')</th>--}}
                                            {{--<th>@lang('validation.custom.weekdays.friday')</th>--}}
                                            {{--<th>@lang('validation.custom.weekdays.saturday')</th>--}}
                                            {{--<th>@lang('validation.custom.weekdays.sunday')</th>--}}
                                            {{--<th hidden="hidden">tp_id</th>--}}
                                        {{--</tr>--}}
                                        {{--@php--}}
                                            {{--$i = 1;--}}
                                        {{--@endphp--}}

                                        {{--@foreach ($uniqueTimeperiods as $timeperiod)--}}
                                            {{--<tr>--}}
                                                {{--<td class="text-center"><input type="checkbox" name="selection_timeperiod[]" id="t{{ $timeperiod['tp_id'] }}" value="t{{ $timeperiod['tp_id'] }}"/></td>--}}
                                                {{--<td>{{ $timeperiod['tp_name'] }}</td>--}}
                                                {{--<td>{{ $timeperiod['tp_monday'] }}</td>--}}
                                                {{--<td>{{ $timeperiod['tp_tuesday'] }}</td>--}}
                                                {{--<td>{{ $timeperiod['tp_wednesday'] }}</td>--}}
                                                {{--<td>{{ $timeperiod['tp_thursday'] }}</td>--}}
                                                {{--<td>{{ $timeperiod['tp_friday'] }}</td>--}}
                                                {{--<td>{{ $timeperiod['tp_saturday'] }}</td>--}}
                                                {{--<td>{{ $timeperiod['tp_sunday'] }}</td>--}}
                                                {{--<td hidden="hidden">t{{ $timeperiod['tp_id'] }}</td>--}}
                                            {{--</tr>--}}
                                            {{--@php--}}
                                                {{--$i++;--}}
                                            {{--@endphp--}}
                                        {{--@endforeach--}}
                                    {{--</table>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    {{ "détail du paramétrage" }}
                    <div class="card text-white bg-dark mb-2">
                        <h4 class="card-header">
                            {{ $service['host name'] . " / " . $service['service description']}}
                        </h4>
                        <div class="card-body">
                            {{ "blablaablallbsdsf" }}
                        </div>
                    </div>
                </div>
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