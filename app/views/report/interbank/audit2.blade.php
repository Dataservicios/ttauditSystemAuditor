@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
                <div class="row pt pb">
                    <div class="col-sm-12">
                        <h4 class="report-title">Uso Interbank Agente</h4>
                        <a href="../../reports/interbank/II-UsoInterbankAgente.xlsx" target="_blank">Obtener detalle de auditoria en Excel</a>
                        <div class="row pt pb">
                            <div class="col-sm-6">
                                 <div class="">
                                    <div class="contenedor-report">
                                        <h4>¿El letrero de IBK Agente era visible desde fuera? </h4>

                                        <div class="pt pb">
                                            <p></p>
                                            <div class="btn-group" role="group" aria-label="...">
                                                  <div   class="btn btn-default btn-si">SI</div>
                                                  <div   class="btn btn-default btn-valor">15</div>

                                            </div>
                                            <div class="btn-group" role="group" aria-label="...">
                                                  <div   class="btn btn-default btn-no">No</div>
                                                  <div   class="btn btn-default btn-valor">4</div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                    <div class="">
                                        <div class="contenedor-report">
                                            <h4>¿El Interbank Agente es visible estando dentro del establecimiento?</h4>
                                            <div class="pt pb">
                                                <p></p>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-si">SI</div>
                                                      <div   class="btn btn-default btn-valor">14</div>

                                                </div>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-no">No</div>
                                                      <div   class="btn btn-default btn-valor">0</div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>

            <!--Lista de usuario-->

                <div class="row pt pb">
                        <div class="col-sm-12">
                            <div class="row pt pb">
                                <div class="col-sm-6">
                                    <div class="">
                                        <div class="contenedor-report">
                                            <h4>¿Existe algún otro Agente / corresponsal bancario?</h4>
                                            <div class="pt pb">
                                                <p></p>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-si">SI</div>
                                                      <div   class="btn btn-default btn-valor">14</div>

                                                </div>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-no">No</div>
                                                      <div   class="btn btn-default btn-valor">12</div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="">
                                        <div class="contenedor-report">
                                            <h4>¿Puedo pagar una tarjeta de crédito de Interbank acá?</h4>
                                            <div class="pt pb">
                                                <p></p>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-si">SI</div>
                                                      <div   class="btn btn-default btn-valor">23</div>

                                                </div>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-no">No</div>
                                                      <div   class="btn btn-default btn-valor">4</div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="row pt pb">
                        <div class="col-sm-12">
                            <div class="row pt pb">
                                <div class="col-sm-6">
                                    <div class="">
                                        <div class="contenedor-report">
                                            <h4>¿acá puedo pagar mi teléfono?</h4>
                                            <div class="pt pb">
                                                <p></p>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-si">SI</div>
                                                      <div   class="btn btn-default btn-valor">18</div>

                                                </div>
                                                <div class="btn-group" role="group" aria-label="...">
                                                      <div   class="btn btn-default btn-no">No</div>
                                                      <div   class="btn btn-default btn-valor">8</div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="report-marco ">
                                        <div class="contenedor-report">
                                            <h4> ¿Y en cuál agente me conviene pagar mi teléfono?</h4>

                                            <div class="grafico-circle">
                                                <div id="chartdiv2" style="width: 100%; height: 250px;" ></div>
                                            </div>
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

@section('report')
    <!-- Libreria AMCHART -->


        {{ HTML::script('lib/amcharts/amcharts.js'); }}
        {{ HTML::script('lib/amcharts/serial.js'); }}
        {{ HTML::script('lib/amcharts/pie.js'); }}

        <!-- // Libreria AMCHART -->

        <!-- Data para grafico y generador del gráfico -->
        {{ HTML::script('js/graficos/grafico10.js'); }}
        {{ HTML::script('js/graficos/grafico10.js'); }}
@endsection