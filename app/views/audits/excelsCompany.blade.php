@extends('layouts/adminLayout')
@section('content')
<section>
    @include('audits/partials/menuLeftAudit')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Cliente: {{$customer->fullname}} Campaña: {{$compaigne->fullname}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" >
                </div>
            </div>
            <div class="row pt pb">
                <div class="col-md-12 pb">
                    <div class="report-marco ">
                        <div class="row pl">
                            <div class="col-md-12 ">
                                <h4>Reportes en Excel</h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">
                                <ul>
                                    @foreach($valoresLinksExcels as $valores)
                                        <li><a href="{{$valores['link']}}" target="_blank">{{$valores['nombre']}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
