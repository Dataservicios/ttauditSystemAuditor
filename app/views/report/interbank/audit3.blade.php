@extends('layouts/adminLayout')
@section('content')
<section>
    @include('report/partials/menuLeft')
     <div class="cuerpo">
                    <div class="cuerpo-content">
                            <!--sección titulo y buscador-->


                            <div class="row pt pb">
                                <div class="col-sm-12">
                                    <h4 class="report-title">EVALUACIÓN DE LA TRANSACIÓN</h4>
                                    <div class="row pt pb">
                                       <div class="col-sm-6">


                                                <div class="report-marco ">
                                                    <div class="contenedor-report">
                                                        <h4>Tipo de Transación</h4>

                                                        <div class="grafico-circle">
                                                            <div id="char_tipo_transaccion" style="width: 100%; height: 250px;" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        <div class="col-sm-6">
                                                <div class="">
                                                    <div class="contenedor-report">
                                                        <h4>Al preguntar si se podía hacer la operación correspondiente, ¿el dependiente aceptó realizar la operación?</h4>
                                                        <div class="pt pb">
                                                            <p>Hay agente interbank aquí</p>
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-si">SI</div>
                                                                  <div   class="btn btn-default btn-valor">22</div>

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
                                    <div class="row pt pb">

                                         <div class="col-sm-6">
                                                <div class="">
                                                    <div class="contenedor-report">
                                                        <h4>¿Su solicitud fue atendido de inmediato?</h4>
                                                        <div class="pt pb">
                                                            <!-- <p>Hay agente interbank aquí</p> -->
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-si">SI</div>
                                                                  <div   class="btn btn-default btn-valor">20</div>

                                                            </div>
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-no">No</div>
                                                                  <div   class="btn btn-default btn-valor">2</div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                        </div>

                                       <div class="col-sm-6">

                                                <div class="report-marco ">
                                                    <div class="contenedor-report">
                                                        <h4>Su solicitud no fue atendida de inmediato porque</h4>

                                                        <div class="grafico-circle">
                                                            <div id="char13" style="width: 100%; height: 250px;" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                         </div>



                                    </div>



                                    <div class="row pt pb">

                                       <div class="col-sm-6">

                                                <div class="report-marco ">
                                                    <div class="contenedor-report">
                                                        <h4>Mientras esperaba.. ¿La persona que lo atendió se preocupó por su tiempo…?</h4>

                                                        <div class="grafico-circle">
                                                            <div id="char14" style="width: 100%; height: 250px;" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                         </div>

                                       <div class="col-sm-6">

                                                <div class="report-marco ">
                                                    <div class="contenedor-report">
                                                        <h4>Después de esperar</h4>

                                                        <div class="grafico-circle">
                                                            <div id="char15" style="width: 100%; height: 250px;" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                         </div>
                                    </div>




                                    <div class="row pt pb">
                                      <div class="col-sm-6">
                                                <div class="">
                                                    <div class="contenedor-report">
                                                        <h4>¿La transacción se llegó a realizar de manera exitosa?
     (Se considera exitosa cuando se entrega el voucher)</h4>
                                                        <div class="pt pb">
                                                            <!-- <p>Hay agente interbank aquí</p> -->
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-si">SI</div>
                                                                  <div   class="btn btn-default btn-valor">38</div>

                                                            </div>
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-no">No</div>
                                                                  <div   class="btn btn-default btn-valor">1</div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                        </div>
                                       <div class="col-sm-6">

                                                <div class="report-marco ">
                                                    <div class="contenedor-report">
                                                        <h4>¿Cuántos MINUTOS transcurrieron entre que solicitó la transacción y la persona terminó
     (le entregó el voucher)?</h4>

                                                        <div class="grafico-circle">
                                                            <div id="char17" style="width: 100%; height: 250px;" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                         </div>



                                    </div>
                                </div>



                                <div class="row pt pb">
                                      <div class="col-sm-6">
                                                <div class="">
                                                    <div class="contenedor-report">
                                                        <h4>¿La persona que lo atendió tuvo que solicitar ayuda de alguna otra persona o hacer alguna consulta al respecto?</h4>
                                                        <div class="pt pb">
                                                            <!-- <p>Hay agente interbank aquí</p> -->
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-si">SI</div>
                                                                  <div   class="btn btn-default btn-valor">2</div>

                                                            </div>
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-no">No</div>
                                                                  <div   class="btn btn-default btn-valor">19</div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                        </div>
                                      <div class="col-sm-6">
                                                <div class="">
                                                    <div class="contenedor-report">
                                                        <h4>¿Le entregaron ESPONTÁNEAMENTE un comprobante luego de la transacción?
    </h4>
                                                        <div class="pt pb">
                                                            <!-- <p>Hay agente interbank aquí</p> -->
                                                            <div class="btn-group" role="group" aria-label="...">
                                                                  <div   class="btn btn-default btn-si">SI</div>
                                                                  <div   class="btn btn-default btn-valor">15</div>

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




                                    <div class="row pt pb">

                                       <div class="col-sm-6">

                                                <div class="report-marco ">
                                                    <div class="contenedor-report">
                                                        <h4> ¿Por qué no se pudo realizar la transacción?</h4>

                                                        <div class="grafico-circle">
                                                            <div id="char20" style="width: 100%; height: 250px;" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                         </div>

                                       <div class="col-sm-6">

                                                <div class="report-marco ">
                                                    <div class="contenedor-report">
                                                        <h4>Después de esperar</h4>

                                                        <div class="grafico-circle">
                                                            <div id="char21" style="width: 100%; height: 250px;" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                         </div>
                                    </div>
                                </div>

                            </div>

                        <!--Lista de usuario-->


                        <!-- Paginador-->



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
        {{ HTML::script('js/graficos/tipo_transaccion.js'); }}
        {{ HTML::script('js/graficos/grafico13.js'); }}
        {{ HTML::script('js/graficos/grafico14.js'); }}
        {{ HTML::script('js/graficos/grafico15.js'); }}
        {{ HTML::script('js/graficos/grafico17.js'); }}
        {{ HTML::script('js/graficos/grafico20.js'); }}
        {{ HTML::script('js/graficos/grafico21.js'); }}


@endsection