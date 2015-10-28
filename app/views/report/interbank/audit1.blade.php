@extends('layouts/layout')
@section('content')
<section>

    <div class="cuerpo">
        <div class="cuerpo-content">
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <h4 class="report-title">Operaciones Varias</h4>
                        <div class="row pt pb">
                            <div class="col-sm-6">
                                <div class="report-marco ">
                                    <div class="contenedor-report">
                                        <h4>Excel Leído</h4>

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Id
                                                    </th>
                                                    <th>
                                                        Ejecutivo
                                                    </th>
                                                    <th>
                                                        Rubro
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($valores as $valor)
                                                <tr>
                                                    <th scope="row">{{$valor['Codigo']}}</th>
                                                    <td>{{$valor['Ejecutivo']}}</td>
                                                    <td>{{$valor['Rubro']}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
    </div>

</section>
@stop

