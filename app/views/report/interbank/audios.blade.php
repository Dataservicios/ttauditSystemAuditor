@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <!--sección titulo y buscador-->

            <div class="row pt pb">
                <div class="col-sm-12">
                    <h4 class="report-title">Lista de Audios</h4>
                    <div class="row pt pb">
                        <div class="col-sm-12">
                            @foreach ($valAudios as $audios)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">{{$audios['contador']}}</span> {{$audios['agente']}}</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-8">
                                            <b> CODIGO:  </b>{{$audios['codclient']}}<br/>
                                            <b> DIRECCION:  </b>{{$audios['direccion']}} <br/>
                                            <b> UBIGEO:  </b>{{$audios['ubigeo']}}<br/>
                                        </div>
                                        <div class="col-sm-4">
                                            <audio src="{{$audios['archivo']}}" controls preload="none"  >
                                                "HTML5 audio not supported";
                                            </audio>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop