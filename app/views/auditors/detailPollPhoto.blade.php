@extends('layouts/adminLayout')
@section('scripts_angular')
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.13/angular.min.js') }}
    {{ HTML::script('js/app.js') }}
@stop
@section('content')
<section>
    @include('auditors/partials/menuLeft')
    <div class="cuerpo" ng-app="MyStores">
        <div class="cuerpo-content" ng-controller="SearchCtrl">
            {{ Form::open(['route' => 'auditorInsertPhotos', 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'pollPhoto' , 'validate']) }}
            <div class="row">
                <div class="col-sm-12">
                    <h4>Pregunta: {{$question->question}}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <input type="text" class="form-control" placeholder="Digite DIR Agente" ng-model="searchInput" ng-change="search()">

                </div>
                <div class="col-sm-8">
                    <div class="list-group" ng-repeat="store in stores">
                        <p class="list-group-item-heading">
                            {{--<a href="#" id="@{{ store.id }}"  class="list-group-item" >@{{ store.codclient }} | @{{ store.fullname }}</a>--}}
                            {{--<a href="#" id="@{{ store.id }}"  class="list-group-item " >@{{ store.codclient }} | @{{ store.fullname }}</a>--}}
                            <a href="#" id="@{{ store.id }}" ng-click="clickSimple(store.codclient); clickId(store.id)" ng-model="searchData"    class="list-group-item " >@{{ store.codclient }} | @{{ store.fullname }}</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 pr">
                    {{--<p>@{{ searchId }}</p>--}}
                    {{ Form::hidden('poll_id', $poll_id) }}
                    {{ Form::hidden('tipo', 1) }}
                    {{ Form::hidden('company_id', $company_id) }}
                    {{ Form::hidden('store_id', '',['id' => 'store_id']) }}
                    <div class="form-group">
                        {{ Form::label('codclient', 'Agente',['class' => 'col-sm-4 control-label']) }}
                        <div class="col-sm-8">
                            {{ Form::text('codclient', ' ', ['class' => 'form-control','style' => 'display:none']) }}
                            {{ $errors->first('codclient', '<div class="alert alert-danger" role="alert">:message</div>') }}
                        </div>
                    </div>
                    {{--<div class="form-group">
                        {{ Form::label('store_id', 'Seleccionar Agente',['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-7">
                            {{ Form::select('store_id', $stores, $selected, ['class' => 'form-control']) }}
                            {{ $errors->first('store_id', '<div class="alert alert-danger" role="alert">:message</div>') }}
                        </div>
                    </div>--}}
                    <div class="form-group">
                        {{ Form::label('archivo', 'Foto',['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-7">
                            {{ Form::file('archivo') }}
                            {{ $errors->first('archivo', '<div class="alert alert-danger" role="alert">:message</div>') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" col-sm-7">
                            <button type="submit" class="btn btn-default btn-sm">GUARDAR</button>
                        </div>
                    </div>

                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</section>
@stop
@section('report')

        <script>

        function ejecutaEvento(valor,tipo){
                //$('#auditor').on('change', 'select', function (e) {
                // var val = $(e.target).val();
               //  var text = $(e.target).find("option:selected").text(); //only time the find is required
                // var name = $(e.target).attr('name');
                console.log(valor.value);
                if (tipo==1){
                    user = valor.options[valor.selectedIndex].value;
                    $('#distrito').prop('disabled',false);
                    $('#distrito option').remove();
                    $("#distrito").append("<option value='0'>--Seleccione--</option>");
                    if ((user != 1) && (user != 2) && (user != 3) && (user != 4) && (user != 5)){
                        $('#distrito').prop('disabled',false);
                        $('#distrito option').remove();
                        $.post('http://ttaudit.com/getDistrictxRegion',{ region : valor.value }, function(json){
                            //if (item.latitud != 0 && item.longitud != 0){
                            poblandoCombo(json,tipo);
                        });
                    }

                }

                if (tipo==2){
                    $('#ejecutivo').prop('disabled',false);
                    $('#ejecutivo option').remove();
                    $('#rubro option').remove();
                    $('#rubro').prop('disabled',true);
                    $("#rubro").append("<option value='0'>--Seleccione--</option>");
                    user = valor.options[valor.selectedIndex].text;
                    //});
                    $.post('http://ttaudit.com/getEjecutivoxRegionxDistric',{ district : valor.value }, function(json){
                        //if (item.latitud != 0 && item.longitud != 0){
                        poblandoCombo(json,tipo);
                    });
                }

                if (tipo==3){
                    $('#rubro').prop('disabled',false);
                    $('#rubro option').remove();
                    user = valor.options[valor.selectedIndex].text;
                    //});
                    $.post('http://ttaudit.com/getRubroxEjecxRegionxDistric',{ ejecutivo : valor.value }, function(json){
                        //if (item.latitud != 0 && item.longitud != 0){
                        poblandoCombo(json,tipo);
                    });
                }
        }

        function poblandoCombo(data,tipo) {
            var total_puntos = 0;
            if (tipo==1){
                $("#distrito").append("<option value='0'>--Seleccione un Distrito--</option>");
                $.each(data, function (i, item) {
                    console.log(item);
                    $("#distrito").append("<option value=\""+ item.region + "|" + item.id +"\">"+ item.fullname +"</option>");
                });
            }

            if (tipo==2){
                $("#ejecutivo").append("<option value='0'>--Seleccione un Ejecutivo--</option>");
                $.each(data, function (i, item) {
                    console.log(item);
                    $("#ejecutivo").append("<option value=\"" + item.id +"\">"+ item.fullname +"</option>");
                });
            }

            if (tipo==3){
                $("#rubro").append("<option value='0'>--Seleccione Rubro--</option>");
                $.each(data, function (i, item) {
                    console.log(item);
                    $("#rubro").append("<option value=\"" + item.id +"\">"+ item.fullname +"</option>");
                });
            }
        }
        </script>

@endsection