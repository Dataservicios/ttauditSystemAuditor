@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeftMediaConcept')
    @if ($userType == 'company')
    <div class="cuerpo">
        <div class="cuerpo-content">
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <div class="report-marco ">
                            <div class="contenedor-report">
                                <h4>Auditorias Media concept</h4>
                                Bienvenidos a las Encuestas de mercados empresa Media Concept

                            </div>
                        </div>

                    </div>

                </div>
        </div>
    </div>
    @endif

</section>
@stop
@section('report')


@endsection