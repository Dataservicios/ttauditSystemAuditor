@extends('layouts/adminLayout')
@section('content')
<section>

    <div class="row pt pb">
        <div class="col-sm-4">
            </div>
        <div class="col-sm-4">
            <div class="report-marco ">
                <div class="contenedor-report">
                    <h4>Seleccione  {{$titulo}}</h4>

                    <ul class="list-group">

                        @foreach ($links as $link)
                            @if($link['target']==0)
                            <li class="list-group-item"><a href="{{$link['url']}}"> {{$link['nombre']}}</a></li>
                            @else
                                <li class="list-group-item"><a href="{{$link['url']}}" target="_blank"> {{$link['nombre']}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-sm-4">
            </div>

    </div>

</section>
@stop
@section('report')


@endsection