@extends('layouts/clienteIBK')
@section('content')
<section>
    @include('report/partials/menuPrincipalInterbank')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">{{$titulo}}</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="200px">
                </div>
            </div>
            <div class="row pt pb">
                <div class="col-sm-12">
                    <div class="row pt pb">
                        <div class="col-sm-12">
                            <!-- Inicia ventana Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                                            <h4 class="modal-title" id="myModalTitle">Modal title</h4>
                                        </div>
                                        <div class="modal-body" id="myModalBody">
                                            ...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fin ventana Modal -->



                            <!-- INICIO DE PANEL PARA CONTENIDOS-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4>{{$objAlert->titulo}} <span class="label label-danger">(ID:{{$objAlert->store_id}})</span></h4>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <div class="text-right"><b>{{date('d F Y G:i:s',strtotime($objAlert->created_at))}}</b></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <b>MOTIVO: </b> {{$objAlert->motivo}}  <br>
                                            <b>DIR: {{$objStore->codclient}}</b> <br>
                                            <b>NOMBRE: </b> {{$objStore->fullname}} <br>
                                            <b>DIRECCION:</b>  {{$objStore->address}} <br>
                                            <b>DISTRITO: </b> {{$objStore->district}} <br>
                                            <b>DEPARTAMENTO:</b> {{$objStore->ubigeo}} <br>
                                            <b>EJECUTIVO: {{$objEjecutivo->fullname}}</b> <br>
                                            <b>AUDITOR: </b> {{$objAuditor->fullname}}  <br>
                                        </div>
                                        <div class="col-lg-6">
                                            @if(count($datosFoto)>0)
                                                @foreach ($datosFoto as $index1 => $detailFoto)
                                                    @if ($detailFoto['id']==0)

                                                    @else
                                                        <a href="{{$detailFoto['urlFoto']}}" class="zoom1 btn btn-default" data-fancybox-group="button"><img src="{{$detailFoto['urlFoto']}}" width="90px" class="img-thumbnail"></a>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row pt">
                                        <div class="col-lg-12">
                                            <h>Responder</h>
                                            <textarea class="form-control" rows="3" id="txt-message" ></textarea>
                                            {{ Form::hidden('user_father_id', 0, ['id'=>'user_father_id']) }}
                                            {{ Form::hidden('user_id', Auth::id(), ['id'=>'user_id']) }}
                                            {{ Form::hidden('name_user_id', Auth::user()->fullname, ['id'=>'name_user_id']) }}
                                            {{ Form::hidden('emails', $objAlert->emails, ['id'=>'emails']) }}
                                            {{ Form::hidden('alert_id', $objAlert->id, ['id'=>'alert_id']) }}
                                        </div>
                                    </div>
                                    <div class="row pt">
                                        <div class="col-lg-12">
                                            <a href='#' class="btn btn-default" id="bt-response">RESPONDER</a>

                                        </div>
                                    </div>
                                    <div class="row pt">
                                        <div class="col-lg-12">
                                            <h>Respuesta</h>
                                            <ul class="list-group" id="response">

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row pt">
                                        <div class="col-lg-12">
                                            <h>Respuestas anteriores</h>
                                            @if(count($arrayComments)>0)
                                                @foreach($arrayComments as $arrayComment)
                                                    <div class="row pt">
                                                        <div class="col-lg-4">
                                                            <span class='label label-danger '> <span class='glyphicon glyphicon-user'></span> {{$arrayComment['creator']}}</span>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <span > {{date('d F Y G:i:s',strtotime($arrayComment['created_at']))}}</span>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <span > {{'IP: '.$arrayComment['ip']}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row pt">
                                                        <div class="col-lg-12">{{$arrayComment['comment']}}</div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIN DE PANEL PARA CONTENIDOS-->
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

        {{ HTML::script('js/graficos/chart.js'); }}

        <!-- // Libreria AMCHART creaGraficoColumnas(chartData2,"char3");	-->


        <script>
            var url_base =  "{{ URL::to('/') }}" ;

            function insertComment(message, alert_id,user_father_id,user_id,name_user_id,emails) {
                var jqxhr = $.post("{{route('ajxInsertCommentAlert')}}", { alert_id : alert_id, message : message , user_id : user_id,user_father_id : user_father_id,emails : emails },  function(data) {
                    console.log ("success => " + data);

                })
                        .done(function() {
                            var f = new Date();
                            cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds();
                            fecha = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear() + " " + cad;

                            var valueString = createElement(name_user_id,fecha, message);
                            $( "#response" ).append( $( valueString ) );
                            $('#myModal').modal('toggle');
                        })
                        .fail(function() {
                            alert( "error" );
                        })
                        .always(function() {
                        });
            }

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();

                $('.dropdown-toggle').dropdown()
            });

            function showMyModalSetTitle(myTitle, myBodyHtml, id) {
                ;
                $('#myModalTitle').html(myTitle);
                $('#myModalBody').html(myBodyHtml);
                $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });

            }

            $('#btAceptar').on("click", function () {
                //console.log($(this).text());
                $('#myModal').modal('toggle');
            });

            $('#bt-response').on("click", function (e) {

                e.preventDefault(e);
                showMyModalSetTitle("Notificación","Espere por favor, cargando contenido....");
                message = $('#txt-message').val();
                $('#txt-message').val("");
                var alert_id = $('#alert_id').val();
                var user_father_id = $('#user_father_id').val();
                var user_id = $('#user_id').val();
                var name_user_id = $('#name_user_id').val();
                var emails = $('#emails').val();

                insertComment(message,alert_id,user_father_id,user_id,name_user_id,emails);

                //console.log($(this).text());

            });

            function createElement(user,date_creation,message){

                var string = "<li class='list-group-item list-group-item-success'> " +
                        "<div><span class='label label-danger '> <span class='glyphicon glyphicon-user'></span> " + user +
                        "</span> " + " <b> " + date_creation + "</b> " + " </div> " + message + " </li> ";
                return string;

            }

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();

                $('.dropdown-toggle').dropdown()
            })


            // Habilitando y deshabilitando radio buttons
            // Añadiendo efecto show y Hiden a los paneles
            $("input[name=optionsRadios5]:radio").click(function() {
                if($(this).attr("value")=="si") {
                    // $(".inputclassname").show();

                    console.log("Si");

                    $("input[name=optionsRadios6]:radio").attr("disabled",false);
                    $( "#panel7" ).show( "slow" );
                    $( "#panel8" ).show( "slow" );

                }
                if($(this).attr("value")=="no") {
                    // $(".inputclassname").hide();
                    console.log("No");
                    $("input[name=optionsRadios6]:radio").attr("disabled",true);
                    $( "#panel7" ).hide( "slow" );
                    $( "#panel8" ).hide( "slow" );

                }
            });
        </script>
@endsection