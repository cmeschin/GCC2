@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            <span class="fas fa-check gcc-text-ok"> @lang('validation.custom.selection')</span>
        @endslot
        <form id="submitSelection" method="POST" action="{{ route('parametrage',$refDemande) }}">
            {{ csrf_field() }}
            <div class="row">
            	<div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a class="color-tessi-clair" role="button" data-toggle="collapse" data-parent="#accordion" href="#listServices"
                               aria-expanded="true" aria-controls="collapseOne">
                              @lang('validation.custom.list_of_services')
                            </a>
                          </h4>
                        </div>
                        <div id="listServices" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body responsive-table-line" style="margin:0 auto">
                              <table id="T_List_Service" class="table table-bordered table-condensed table-body-center">
                                  <tr class="text-center color-tessi-clair">
                                      <th></th>
                                      <th>Hôte</th>
                                      <th>Service</th>
                                      <th>Fréquence</th>
                                      <th>Plage Horaire</th>
                                      <th>Controle</th>
                                      <th hidden="hidden">service_id</th>
                                      <th hidden="hidden">host_id</th>
                                  </tr>
                                  @php
                                      $hote_nom = "";
                                  @endphp

                                  @foreach ($services as $service)
                                      @php
                                        //$hote_nom_actuel = $service['nom'];

                                        if ($hote_nom != $service['nom']){
                                          $j = 1;
                                          $hote_nom = $service['nom'];
                                          //$hote_site = $service['site'];
                                        }
                                      @endphp
                                      @if ($service['host_activate'] == 0 || $service['service_activate'] == 0)
                                          {{--// mise en couleur pour les controles inactifs--}}
                                          <tr class="gcc-disabled">
                                      @else
                                          <tr>
                                      @endif
                                      <td class="text-center"><input title="check_service" type="checkbox" name="selection_service[]" id="s{{ $service['service_id'] }}" value="{{ $service['service_id'] }}"/></td>
                                      @if ($j  == 1 || $j % 10 == 0)
                                          <td class="badge-info tooltip-link" data-toggle="tooltip"
                                              data-original-title="{{ $service['host_address'] }} - {{ $service['site'] }}">{{ $service['nom'] }}</td>
                                      @else
                                          <td></td>
                                      @endif
                                      @if ($service['service_activate'] == 1 && $service['host_activate'] == 1)
                                          <td><a target="_blank" href="http://192.168.0.22/centreon/main.php?p=20201&o=svcd&host_name={{ $service['host_name'] }}&service_description={{ $service['service_description'] }}">{{ $service['service_description'] }}</a></td>
                                      @else
                                          <td>{{ $service['service_description'] }}</td>
                                      @endif
                                      <td>{{ $service['service_interval'] }}</td>
                                      <td>{{ $service['tp_name'] }}</td>
                                      @if ($service['host_activate'] == 0)
                                          <td>hôte désactivé</td>
                                      @elseif ($service['service_activate'] == 0)
                                          <td>désactivé</td>
                                      @else
                                          <td>actif</td>
                                      @endif
                                      <td hidden>s{{ $service['service_id'] }}</td>
                                      <td hidden>h{{ $service['host_id'] }}</td>
                                      </tr>
                                      @php
                                          $j++;
                                      @endphp
                                  @endforeach
                              </table>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                          <h4 class="panel-title">
                            <a class="collapsed color-tessi-clair" role="button" data-toggle="collapse" data-parent="#accordion" href="#listHosts"
                               aria-expanded="false" aria-controls="collapseTwo">
                                @lang('validation.custom.list_of_hosts')
                            </a>
                          </h4>
                        </div>
                        <div id="listHosts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                              <table id="T_List_Host" class="table table-bordered table-condensed table-body-center">
                                  <tr class="text-center color-tessi-clair">
                                      <th></th>
                                      <th>Hostname</th>
                                      <th>IP</th>
                                      <th>Description</th>
                                      <th>Contrôle</th>
                                      <th>Site</th>
                                      <th>Solution</th>
                                      <th>Type</th>
                                      {{--<th>Architecture</th>--}}
                                      <th>Fonction</th>
                                      {{--<th>Langue</th>--}}
                                      <th>OS</th>
                                      <th>Type</th>
                                      <th hidden="hidden">host_id</th>
                                  </tr>
                                  {{--@php--}}
                                      {{--$i = 1;--}}
                                  {{--@endphp--}}

                                  @foreach ($hosts as $host)
                                      @if ($host['host_activate'] == 0)
                                          {{--// mise en couleur pour les controles inactifs--}}
                                          <tr class="gcc-disabled">
                                      @else
                                          <tr>
                                      @endif
                                          <td class="text-center"><input type="checkbox" name="selection_host[]" id="h{{ $host['host_id'] }}" value="{{ $host['host_id'] }}"/></td>
                                          @if ($host['host_activate'] == 1)
                                              <td><a target="_blank" href="http://192.168.0.22/centreon/main.php?p=20201&o=svcd&host_name={{ $host['host_name'] }}">{{ $host['host_name'] }}</a></td>
                                          @else
                                              <td>{{ $host['host_name'] }}</td>
                                          @endif
                                          <td>{{ $host['host_address'] }}</td>
                                          <td>{{ $host['host_alias'] }}</td>
                                          @if ($host['host_activate'] == 0)
                                              <td>désactivé</td>
                                          @else
                                              <td>actif</td>
                                          @endif
                                          <td>{{ $host['GroupeSite'] }}</td>
                                          <td>{{ $host['GroupeSolution'] }}</td>
                                          <td>{{ $host['GroupeType'] }}</td>
                                          {{--<td>{{ $host['CategorieArchitecture'] }}</td>--}}
                                          <td>{{ $host['CategorieFonction'] }}</td>
                                          {{--<td>{{ $host['CategorieLangue'] }}</td>--}}
                                          <td>{{ $host['CategorieOS'] }}</td>
                                          <td>{{ $host['CategorieType'] }}</td>
                                          <td hidden="hidden">{{ $host['host_id'] }}</td>
                                      </tr>
                                      {{--@php--}}
                                          {{--$i++;--}}
                                      {{--@endphp--}}
                                  @endforeach
                              </table>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                          <h4 class="panel-title">
                            <a class="collapsed color-tessi-clair" role="button" data-toggle="collapse" data-parent="#accordion" href="#listTimeperiods"
                               aria-expanded="false" aria-controls="collapseThree">
                                @lang('validation.custom.list_of_timeperiods')
                            </a>
                          </h4>
                        </div>
                        <div id="listTimeperiods" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                          <div class="panel-body">
                              <table id="T_List_Timeperiod" class="table table-bordered table-condensed table-body-center">
                                  <tr class="text-center color-tessi-clair">
                                      <th></th>
                                      <th>@lang('validation.custom.timeperiod')</th>
                                      <th>@lang('validation.custom.weekdays.monday')</th>
                                      <th>@lang('validation.custom.weekdays.tuesday')</th>
                                      <th>@lang('validation.custom.weekdays.wednesday')</th>
                                      <th>@lang('validation.custom.weekdays.thursday')</th>
                                      <th>@lang('validation.custom.weekdays.friday')</th>
                                      <th>@lang('validation.custom.weekdays.saturday')</th>
                                      <th>@lang('validation.custom.weekdays.sunday')</th>
                                      <th hidden="hidden">tp_id</th>
                                  </tr>
                              {{--@php--}}
                                  {{--$i = 1;--}}
                              {{--@endphp--}}

                              @foreach ($uniqueTimeperiods as $uniqueTp)
                                  <tr>
                                      <td class="text-center"><input type="checkbox" name="selection_timeperiod[]" id="t{{ $uniqueTp['tp_id'] }}" value="{{ $uniqueTp['tp_id'] }}"/></td>
                                      <td>{{ $uniqueTp['tp_name'] }}</td>
                                      <td>{{ $uniqueTp['tp_monday'] }}</td>
                                      <td>{{ $uniqueTp['tp_tuesday'] }}</td>
                                      <td>{{ $uniqueTp['tp_wednesday'] }}</td>
                                      <td>{{ $uniqueTp['tp_thursday'] }}</td>
                                      <td>{{ $uniqueTp['tp_friday'] }}</td>
                                      <td>{{ $uniqueTp['tp_saturday'] }}</td>
                                      <td>{{ $uniqueTp['tp_sunday'] }}</td>
                                      <td hidden="hidden">{{ $uniqueTp['tp_id'] }}</td>
                                  </tr>
                                  {{--@php--}}
                                      {{--$i++;--}}
                                  {{--@endphp--}}
                              @endforeach
                              </table>
                          </div>
                        </div>
                      </div>
                    </div>
				</div>
			</div>
            <div class="col-md-8 offset-md-2">
                @component('components.waiting')
                    @lang('pagination.waiting')
                @endcomponent
            </div>
            @component('components.button-next')
            @endcomponent
        </form>
    @endcomponent
@endsection

@section('script')
    <script>
        $(function()
        {
            $(".tooltip-link").tooltip();
        });
        $("[id^='submit']").submit(function(){ //fonction permettant d'afficher le message d'attente
            waiting();
        });

    </script>
@endsection