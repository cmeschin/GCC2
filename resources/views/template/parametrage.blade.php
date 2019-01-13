@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            <span class="fas fa-edit gcc-nok"> @lang('validation.custom.parametrage')</span>
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
                                        <div class="col-md-3">
                                            <table id="T_List_Service" class="table table-bordered table-condensed table-body-center">
                                                <tr class="text-center color-tessi-clair">
                                                    <th>Service</th>
                                                    <th>Etat</th>
                                                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="true" aria-controls="multiCollapse">Afficher/Masquer tous les éléments</button>
                                                </tr>
                                                @if (count($myServices) > 0)

                                                    @foreach ($myServices as $service)
                                                        <tr>
                                                            <td>
                                                                <a data-toggle="collapse" href="#collapseS{{ $service['service id']}}" role="button" aria-expanded="false" aria-controls="collapseS{{ $service['service id']}}">
                                                                    {{ $service['host name'] . " / " . $service['service description'] }}
                                                                </a>
                                                            </td>
                                                            <td id="S{{ $service['service id'] }}"><span class="fas fa-edit gcc-nok">NOK</span><span class="fas fa-check gcc-ok">OK</span></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-9">
                                            @foreach ($myServices as $service)
                                                <div class="collapse multi-collapse" id="collapseS{{ $service['service id'] }}">
                                                    {{--<div class="card card-body">--}}
                                                        {{--@php(dd($sites))--}}
                                                        {{--@include('template.host')--}}
                                                    {{--</div>--}}
                                                </div>
                                            @endforeach
                                        </div>
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
                                        <div class="col-md-3">
                                            <table id="T_List_Host" class="table table-bordered table-condensed table-body-center">
                                                <tr class="text-center color-tessi-clair">
                                                    <th>Hôte</th>
                                                    <th>Etat</th>
                                                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="true" aria-controls="multiCollapse">Afficher/Masquer tous les éléments</button>
                                                </tr>
                                                @if (count($myHosts) > 0)
                                                    @foreach ($myHosts as $host)

                                                        <tr>
                                                            <td>
                                                                <a data-toggle="collapse" href="#collapseH{{ $host['host_id']}}" role="button" aria-expanded="false" aria-controls="collapseH{{ $host['host_id']}}">
                                                                    {{ $host['host_name'] . " / " . $host['host_address'] }}
                                                                </a>
                                                            </td>
                                                            <td id="H{{ $host['host_id'] }}"><span class="fas fa-edit gcc-nok">NOK</span><span class="fas fa-check gcc-ok">OK</span></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-9">
                                            @if (count($myHosts) > 0)
                                            @foreach ($myHosts as $host)
                                                {{--@php(var_dump($host))--}}
                                                <div class="collapse multi-collapse" id="collapseH{{ $host['host_id'] }}">
                                                    <div class="card card-body">
                                                    {{--@php(dd($sites))--}}
                                                    @include('template.host')
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
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
			</div>
            @component('components.button-next')
            @endcomponent
        </form>
    @endcomponent
@endsection

@section('script')
    <script>
        // $(document).ready(function() {
            $('.select2').select2();
        // });
    </script>
@endsection