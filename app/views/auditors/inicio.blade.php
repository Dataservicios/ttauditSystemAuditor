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
                                <h4>Operaciones Programadas</h4>

                            </div>
                        </div>

                    </div>

                </div>
        </div>
    </div>
    @endif
</section>
@stop
