@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            <span id="title" class="fas fa-edit gcc-text-nok">{{ $refDemande }}: @lang('validation.custom.parametrage')</span>
        @endslot
        <form id="submitParametrage" method="POST" action="{{ route('validation',$refDemande) }}">
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="T_List_Service" class="table table-bordered table-condensed table-body-center">
                                                <tr class="text-center color-tessi-clair">
                                                    <th>N°</th>
                                                    <th>Service</th>
                                                    <th>Etat</th>
                                                    <th>Actions</th>
                                                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="true" aria-controls="multiCollapse">Afficher/Masquer tous les éléments</button>
                                                </tr>
                                                @php($numService=1)
                                                @foreach ($services as $service)
                                                    @if ($service['selected'] == true)
                                                        @if ($service['service_activate'] == 1)
                                                            @php($Etat = "Actif")
                                                        @elseif ($service['service_activate'] == 0)
                                                            @php($Etat = "Inactif")
                                                        @else
                                                            @php($Etat = $service['service_activate'])
                                                        @endif
                                                        <tr id="S{{ $service['service_id'] }}">
                                                            <td rowspan="2" class="text-center">
                                                                {{ $numService }}
                                                            </td>
                                                            <td>
                                                                <a data-toggle="collapse" href="#collapseS{{ $service['service_id']}}" role="button" aria-expanded="false" aria-controls="collapseS{{ $service['service_id']}}">
                                                                    {{ $service['host_name'] . " / " . $service['service_description'] }}
                                                                </a>
                                                            </td>
                                                            <td id="S{{ $service['service_id'] }}">
                                                                <span class="fas fa-edit gcc-text-nok">NOK</span>
                                                                <span class="fas fa-check gcc-text-ok">OK</span>
                                                            </td>
                                                            <td id="S{{ $service['service_id'] }}">
                                                                    <button id="ajaxDelete_S{{ $service['service_id'] }}" class="btn btn-secondary color-tessi-fonce float-right ajaxDelete" action="{{ route('delservice', ['refdemande' => $refDemande, 'serviceid' => $service['service_id']]) }}">
                                                                        <span title="Supprimer le service {{ $numService }} de la demande" class="fas fa-trash color-tessi-fonce" ></span>
                                                                    </button>
                                                                @component('components.button-simple')
                                                                    <span title="Dupliquer le service {{ $numService }}." class="fas fa-copy color-tessi-fonce"></span>
                                                                @endcomponent
                                                                @component('components.button-simple')
                                                                    <span title="Vérifier le paramétrage du service {{ $numService }}." class="fas fa-check-double color-tessi-fonce"></span>
                                                                @endcomponent
                                                            </td>
                                                        </tr>
                                                        <td colspan="3">
                                                        <div class="col-md-12">
                                                            <div class="collapse multi-collapse" id="collapseS{{ $service['service_id'] }}">
                                                                @include('template.service')
                                                            </div>
                                                        </div>
                                                        </td>
                                                        @php($numService++)
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
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
                                <div class="panel-body responsive-table-line" style="margin:0 auto">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="T_List_Host" class="table table-bordered table-condensed table-body-center">
                                                <tr class="text-center color-tessi-clair">
                                                    <th>N°</th>
                                                    <th>Hôte</th>
                                                    <th>Etat</th>
                                                    <th>Actions</th>
                                                    {{--<button class="btn btn-info" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="true" aria-controls="multiCollapse">Afficher/Masquer tous les éléments</button>--}}
                                                </tr>
                                                {{--@if (count($myHosts) > 0)--}}
                                                @if ($hosts)
                                                    @php($numHost=1)
                                                    @foreach ($hosts as $host)
                                                        <tr id="S{{ $host['host_id'] }}">
                                                            <td rowspan="2" class="text-center">
                                                                {{ $numHost }}
                                                            </td>
                                                            <td>
                                                                <a data-toggle="collapse" href="#collapseH{{ $host['host_id']}}" role="button" aria-expanded="false" aria-controls="collapseH{{ $host['host_id']}}" title="Cliquer pour déveloper/réduire">
                                                                    {{ $host['host_name'] . " / " . $host['host_address'] }}
                                                                </a>
                                                            </td>
                                                            <td id="H{{ $host['host_id'] }}">
                                                                <span class="fas fa-edit gcc-text-nok">NOK</span>
                                                                <span class="fas fa-check gcc-text-ok">OK</span>
                                                            </td>
                                                            <td id="S{{ $host['host_id'] }}">
                                                                <button id="ajaxDelete_H{{ $host['host_id'] }}" class="btn btn-secondary color-tessi-fonce float-right ajaxDelete" action="{{ route('delhost', ['refdemande' => $refDemande, 'hostid' => $host['host_id']]) }}">
                                                                    <span title="Supprimer l'hôte {{ $numHost }} de la demande" class="fas fa-trash color-tessi-fonce" ></span>
                                                                </button>
                                                                @component('components.button-simple')
                                                                    <span title="Dupliquer l'hôte {{ $numHost }}." class="fas fa-copy color-tessi-fonce"></span>
                                                                @endcomponent
                                                                @component('components.button-simple')
                                                                    <span title="Vérifier le paramétrage de l'hôte {{ $numHost }}." class="fas fa-check-double color-tessi-fonce"></span>
                                                                @endcomponent
                                                            </td>
                                                        </tr>
                                                        <td colspan="3">
                                                            <div class="col-md-12">
                                                                <div class="collapse multi-collapse" id="collapseH{{ $host['host_id'] }}">
                                                                    @include('template.host')
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @php($numHost++)
                                                    @endforeach
                                                @endif
                                            </table>
                                        </div>
                                    </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			{{--</div>--}}
            @component('components.button-next')
            @endcomponent
        </form>
    @endcomponent
@endsection

@section('script')
    <script>
        var title = $(#title).value();
        var refDemande = title.substring(1,title.indexOf(":")-1);
        alert(refDemande);
        $(document).ready(function() {
            $('.select2').select2();
        });

        $('.ajaxDelete').click(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CRSF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: $(this).attr('action'),
                method: 'post',
                data: {
                    refDemande: refDemande,
                    serviceid: $(this).parent().parent().attr('id')
                },
                success: function(result){
                    $(this).parent().parent().remove();
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
        })
    </script>
@endsection