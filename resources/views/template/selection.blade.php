@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('validation.custom.selection')
        @endslot
        <form id="submitSelection" method="POST" action="">
            {{ csrf_field() }}
            <div class="row">
            	<div class="col-md-12">
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
                          <div class="panel-body responsive-table-line" style="margin:0px auto">
                              <table id="T_Liste_Service" class="table table-bordered table-condensed table-body-center">
                                  <tr class="text-center tessi-rose-clair">
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
                                      $i = 1;
                                      $nom_hote = "";
                                  @endphp

                                  @foreach ($services as $service)
                                      @php
                                        $nom_hote_actuel = substr(stristr(substr(stristr($service['host name'],'-'),1),'-'),1);

                                        if ($nom_hote != $nom_hote_actuel){

                                          $j = 1;
                                          $nom_hote = $nom_hote_actuel; // enlève la localisation et la fonction et les deux -
                                          $hote_localisation = stristr($service['host name'],'-',1); // conserve la chaine avant le premier tiret
                                        }
                                      @endphp
                                      @if ($service['host activate'] == 0 || $service['service activate'] == 0)
                                          {{--// mise en couleur pour les controles inactifs--}}
                                          <tr class="tessi-disabled">
                                      @else
                                          <tr>
                                      @endif
                                      <td class="text-center"><input type="checkbox" name="selection_service" id="s{{ $i }}"/></td>
                                      @if ($j  == 1 || $j % 10 == 0)
                                          <td class="badge-info tooltip-link" data-toggle="tooltip"
                                              data-original-title="{{ $service['host address'] }} - {{ $hote_localisation }}">{{ $nom_hote }}</td>
                                      @else
                                          <td></td>
                                      @endif
                                      @if ($service['service activate'] == 1 && $service['host activate'] == 1)
                                          <td><a target="_blank" href="http://192.168.0.7/centreon/main.php?p=20201&o=svcd&host_name={{ $service['host name'] }}&service_description={{ $service['service description'] }}">{{ $service['service description'] }}</a></td>
                                      @else
                                          <td>{{ $service['service description'] }}</td>
                                      @endif
                                      <td>Fréquence</td>
                                      <td>{{ $service['tp name'] }}</td>
                                      <td>{{ $service['service activate'] }}</td>
                                      <td hidden>s{{ $service['service id'] }}</td>
                                      <td hidden>h{{ $service['host id'] }}</td>
                                      </tr>
                                      @php
                                          $i++;
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
                            <a class="collapsed tessi-rose-clair" role="button" data-toggle="collapse" data-parent="#accordion" href="#listHosts"
                               aria-expanded="false" aria-controls="collapseTwo">
                                @lang('validation.custom.list_of_hosts')
                            </a>
                          </h4>
                        </div>
                        <div id="listHosts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                            Mon deuxième beau tableau
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
                            Mon troisième beau tableau
                          </div>
                        </div>
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
        $(function()
        {
            $(".tooltip-link").tooltip();
        });
    </script>
@endsection