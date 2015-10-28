@extends('layouts/adminLayout')
@section('content')
<section>
    @include('auditors/partials/menuLeft')
    @if ($userType == 'auditor')
        <div class="cuerpo">
            <div class="cuerpo-content">
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <div class="report-marco ">
                            <div class="contenedor-report">
                                <h4>Operaciones Interbank
                                    @if($id==1)
                                        Ola 1
                                    @endif
                                    @if($id==8)
                                        Ola 2
                                    @endif
                                </h4>
                                <div class="list-group">
                                @foreach($polls as $poll)
                                    <a href="{{ route('detailPollPhoto', [$poll['poll_id'],$id]) }}" class="list-group-item">  Ingreso de Fotos Pregunta:  {{$poll['poll']}}</a>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
@stop