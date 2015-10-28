@extends('layouts/adminLayout')
@section('content')
<section>
    @include('auditors/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
                <div class="row pt pb">
                    <div class="col-sm-12">
                        @if ($store_id==1244)
                            <h4 class="report-title">Encuestas Media Concept Mercado Ciudad de Dios  - Junio 2015</h4>
                        @endif
                        @if ($store_id==1245)
                            <h4 class="report-title">Encuestas Media Concept Mercado Valle Sagrado  - Junio 2015</h4>
                        @endif
                        @if ($store_id==1246)
                            <h4 class="report-title">Encuestas Media Concept Mercado Virgen de las Mercedes  - Junio 2015</h4>
                        @endif
                        <!-- Inicio de  Alerta para filtros -->
                        @if($mensaje<>"")
                            <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                    <strong>{{$mensaje}}</strong>
                            </div>
                        @endif


                        <!-- FIn de  Alerta para filtros -->

                        <div class="row pt pb">
                           <div class="col-sm-12">


                               <!-- Inicia ventana Modal -->

                               <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                   <div class="modal-dialog modal-sm">
                                       <div class="modal-content">
                                           <div class="modal-header">
                                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                               <h4 class="modal-title" id="myModalTitle">Modal title</h4>
                                           </div>
                                           <div class="modal-body" id="myModalBody">
                                               ...
                                           </div>
                                           <div class="modal-footer">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                               <button type="button" id="btAceptar" class="btn btn-primary" >Aceptar</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <!-- fin ventana Modal -->



                                <!-- INICIO DE PANEL PARA CONTENIDOS-->
                           {{ Form::open(['route' => 'insertResponsePoll', 'files' => false, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'pollResult', 'name' => 'pollResult' , 'validate']) }}
                                {{ Form::hidden('company_id', $company_id) }}
                                {{ Form::hidden('audit_id', $audit_id) }}
                                {{ Form::hidden('store_id', $store_id) }}
                               @foreach ($questionsOptions as $index => $questions)
                               <div class="panel panel-default" id="panel{{$questions['poll_id']}}">
                                   <div class="panel-heading"><h4>{{$index +1}} - {{$questions['question']}}</h4></div>

                                       @if ($questions['sino']==1)
                                       <div class="panel-body" >
                                           @foreach ($questions['valSino'] as $sino)
                                           <div class="radio">
                                              <label>
                                                   {{ Form::radio('sino-'.$questions['poll_id'], $sino['sino'], false, array('id'=>$questions['poll_id'])) }}
                                                 {{$sino['val']}}
                                              </label>
                                          </div>
                                          @endforeach
                                       </div>
                                       @else
                                       {{ Form::hidden('sino-'.$questions['poll_id'], "") }}
                                      @endif

                                       @if ($questions['options']==1)
                                       {{ Form::hidden('option-'.$questions['poll_id'], "opciones:".$questions['poll_id']) }}
                                       <div class="panel-body">
                                           @if ($questions['sino']==1)<blockquote> @endif
                                           @foreach ($questions['valOptions'] as $options)
                                           <div class="radio">
                                               <label>
                                                    @if (($questions['poll_id']==34) or ($questions['poll_id']==36) or ($questions['poll_id']==37) or ($questions['poll_id']==39) or ($questions['poll_id']==40))
                                                        {{ Form::checkbox('option-'.$options['option_id'], $options['option_id'], false, array('id'=>$questions['poll_id']."-".$options['option_id'], 'class'=>$questions['poll_id'])) }}
                                                    @else
                                                        {{ Form::radio('option-'.$options['option_id'], $options['option_id'], false, array('id'=>$questions['poll_id']."-".$options['option_id'],'class'=>$questions['poll_id'])) }}
                                                    @endif

                                                  {{$options['option']}}
                                               </label>
                                           </div>
                                           @endforeach
                                           @if ($questions['sino']==1)</blockquote> @endif
                                       </div>
                                       @else
                                       {{ Form::hidden('option-'.$questions['poll_id'], "") }}
                                       @endif

                               </div>
                               @endforeach
                           {{ Form::close() }}
                               <!-- FIN DE PANEL PARA CONTENIDOS-->


                               <a href='#' class="btn btn-default" onClick="javascript:showMyModalSetTitle('Guardar Encuesta', 'Está seguro que decea guarda la encuesta')">GUARDAR ENCUESTA</a>
                            </div>

                        </div>


                    </div>
                </div>

        </div>

    </div>
</section>
@stop
@section('report')
<script>
    function showMyModalSetTitle(myTitle, myBodyHtml, id) {
       ;
        $('#myModalTitle').html(myTitle);
        $('#myModalBody').html(myBodyHtml);
        $('#myModal').modal('show');

    }

    $('#btAceptar').on("click", function () {
        //console.log($(this).text());
        $('#myModal').modal('toggle');
        $( "#pollResult" ).submit();
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('.dropdown-toggle').toggle();
    })

    //Evento aplicado a las Alertas
    $('#alertaFiltro').on('closed.bs.alert', function () {
        $('#alertaFiltro').dropdown()
    })


    $(".35").attr("disabled",true);
        $("input[name=sino-35]:radio").click(function() {
            if($(this).attr("value")=="1") {
               // $(".inputclassname").show();

                console.log("Si");

                $(".35").attr("disabled",false);
                $( "#panel36" ).show( "slow" );
                $( "#panel37" ).show( "slow" );

            }
            if($(this).attr("value")=="0") {
               // $(".inputclassname").hide();
                console.log("No");
                $(".35").attr("disabled",true);
                $( "#panel36" ).hide( "slow" );
                $( "#panel37" ).hide( "slow" );

            }
        });

        $(".36").attr("disabled",true);
        $("input[name=sino-36]:radio").click(function() {
            if($(this).attr("value")=="1") {
                // $(".inputclassname").show();

                console.log("Si");

                $(".36").attr("disabled",false);
                $(".36").attr("checked",false);


            }
            if($(this).attr("value")=="0") {
                // $(".inputclassname").hide();
                console.log("No");
                $(".36").attr("disabled",true);
                $(".36").attr("checked",false);


            }
        });

        $(".38").attr("disabled",true);
        $("input[name=sino-38]:radio").click(function() {
            if($(this).attr("value")=="2" || $(this).attr("value")=="3" || $(this).attr("value")=="4") {
                // $(".inputclassname").show();

                console.log("Si");

                $(".38").attr("disabled",false);
                $(".38").attr("checked",false);


            }
            if($(this).attr("value")=="0") {
                // $(".inputclassname").hide();
                console.log("No");
                $(".38").attr("disabled",true);
                $(".38").attr("checked",false);


            }
        });


        $(".39").attr("disabled",true);
        $("input[name=sino-39]:radio").click(function() {
            if($(this).attr("value")=="1") {
                // $(".inputclassname").show();

                console.log("Si");

                $(".39").attr("disabled",false);
                $(".39").attr("checked",false);


            }
            if($(this).attr("value")=="0") {
                // $(".inputclassname").hide();
                console.log("No");
                $(".39").attr("disabled",true);
                $(".39").attr("checked",false);


            }
        });
</script>
@endsection