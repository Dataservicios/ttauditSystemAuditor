@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuPrincipalColgate')
    @if ($userType == 'company')
    <div class="cuerpo">
        <div class="cuerpo-content">
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <div class="report-marco ">
                            <div class="contenedor-report">
                                <h4>Auditorias Colgate PILOTO</h4>
                                Bienvenidos a las Auditorias de Colgate

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