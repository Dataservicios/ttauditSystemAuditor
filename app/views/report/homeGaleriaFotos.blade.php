@extends('layouts/adminLayout')
@section('reportCSS')
    <style>
        li.lista-image {

            display:inline;
            float:left;
            width:300px;
            height: 420px;
            background-color:#f5f7f9;
            padding:5px;
            margin:10px;
            text-align: center;
            border-right: #a5a7aa solid 1px;
            border-bottom: #a5a7aa solid 1px;
        }
    </style>
@endsection
@section('content')
<section>
    @include('report/partials/menuPrincipalBayer')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row pt pb">
                <div class="col-sm-9">
                    <h4 class="report-title">Reporte de Fotos</h4>
                </div>
                <div class="col-sm-3">
                    <img src="{{$logo}}" width="100px">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <div id="alertaFiltro" class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <strong>Filtrado por:</strong>
                        Departamento(s)|
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <!--Filtros con combos-->
                                        {{Form::open(['route' => 'reportBayerFilter', 'method' => 'POST', 'role' => 'form'], $audit_id,['class' => 'form-inline'])}}
                                        {{ Form::hidden('audit_id', $audit_id) }}
                                        {{ Form::hidden('company_id', $company_id) }}
                                        @if($customer->corto == 'bayer')
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="operation">Operación</label>
                                                    {{ Form::hidden('operation', "0") }}
                                                    @foreach($ListOperaciones as $operacion)
                                                        <div class="checkbox">
                                                            <label>
                                                                {{Form::radio('operation', $operacion,null, ['class' => 'checkbox1']);}} {{$operacion}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="ubigeo">Departamento</label>
                                                    {{ Form::hidden('ubigeo', "0") }}
                                                    @foreach($ListUbigeos as $ubigeo)
                                                        <div class="checkbox">
                                                            <label>
                                                                {{Form::checkbox('ubigeo[]', $ubigeo,null, ['class' => 'checkbox1']);}} {{$ubigeo}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="cadena">Cadenas</label>
                                                    {{ Form::hidden('cadena', "0") }}
                                                    @foreach($ListCadenas as $cadena1)
                                                        <div class="checkbox">
                                                            <label>
                                                                {{Form::checkbox('cadena[]', $cadena1,null, ['class' => 'checkbox1']);}} {{$cadena1}}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="cadena">Horizontales</label>
                                                    {{ Form::hidden('horizontal', "0") }}
                                                    @foreach($ListHorizontales as $cadena2)
                                                        <div class="checkbox">
                                                            <label>
                                                                {{Form::checkbox('horizontal[]', $cadena2,null, ['class' => 'checkbox1']);}} {{$cadena2}}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="ejecutivo">Ejecutivo</label>
                                                    {{Form::select('ejecutivo', $ejecutivos, '0', ['id'=>'ejecutivo','class' => 'form-control']);}}

                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="rubro">&emsp;</label>
                                                    <button class="btn btn-default" type="submit">Filtrar</button>
                                                </div>
                                            </div>
                                        @endif
                                        {{ Form::close() }}
                                        <!-- Fin Filtros con combos-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt pb">
                <div class="col-sm-12">
                    <ul>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="lista-image">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="badge">2 </span> CADENA - INKAFARMA - INKAFARMA  PIURA 1 1012</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <b> DIRECCIÓN:  </b><br/>
                                            <b> DEPARTAMENTO:  </b>PIURA<br/>
                                            <b> PROVINCIA:  </b>PIURA <br/>
                                            <b> DISTRITO:  </b>PIURA<br/>
                                            <b> AUDITOR:  </b><br/>
                                            <b> FECHA:  </b>2016-08-01 10:47:44<br/>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <a href="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" class="zoom1 btn btn-default" data-fancybox-group="button">
                                            <img src="http://ttaudit.com/media/fotos/009895_33_Bayer_20160801_104902.jpg" width="90px" class="img-thumbnail"></a>
                                    </div>
                                </div>

                            </div>
                        </li>

                    </ul>







                </div>
            </div>

            </div>
        </div>
    </div>

</section>
@stop
@section('report')
    <!--LIBRERIA fancybox PARA ZOOM PARA IMÁGENES-->
    {{ HTML::script('lib/fancybox/jquery.fancybox.js?v=2.1.5'); }}
    {{ HTML::script('lib/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5'); }}
    {{ HTML::script('lib/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); }}
    {{ HTML::script('lib/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6'); }}
    <script>
        $('.zoom1').fancybox(  {
            openEffect : 'elastic',
            openSpeed  : 150,
            closeEffect : 'elastic',
            closeSpeed  : 150,
            prevEffect : 'none',
            nextEffect : 'none',
            closeBtn  : true,
            helpers : {
                title : {
                    type : 'inside'
                },
                buttons : {}
            },

            afterLoad : function() {
                this.title = 'Imagen ' + (this.index + 1) + ' de ' + this.group.length + (this.title ? ' - ' + this.title : '');
            }
        });
    </script>
@endsection