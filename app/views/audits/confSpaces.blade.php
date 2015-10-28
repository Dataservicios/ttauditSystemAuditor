@extends('layouts/adminLayout')
@section('content')
<section>
    @include('partials/leftAudits')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <h4>Auditoria Medición de espacios</h4>
                    <div class="cuerpo-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group btn-group-justified""" role="group" aria-label="...">
                                  <a href="{{ route('insertSpace') }}"><button type="button" class="btn btn-default">New</button></a>
                                  <a href="{{ route('insertSpace') }}"><button type="button" class="btn btn-default">Listar Audit Spaces</button></a>
                                  <br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">

                                {{ Form::open(['route' => 'insertSpace', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form', 'novalidate']) }}
                                    {{ Form::hidden('audit_id', 1, ['class' => 'form-control', 'placeholder' => 'Nombre']) }}

                                    <div class="form-group">
                                        {{ Form::label('company_id', 'Cliente',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::select('company_id', $combobox, $selected, ['class' => 'form-control']) }}
                                            {{ $errors->first('company_id', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('category_product_id', 'Categoria',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            <select id="category_product_id" name="category_product_id" class = 'form-control'> <option>Debe escoger una empresa primero</option> </select>
                                            {{ $errors->first('category_product_id', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('rangos', 'Valor Optimo (Valor Mínimo)',['class' => 'col-sm-4 control-label']) }}<br>
                                        <div class="col-sm-8">
                                            {{ Form::text('green', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('green', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('ambar', 'Rango ambar (Valor Mínimo)',['class' => 'col-sm-4 control-label']) }}<br>
                                        <div class="col-sm-8">
                                            {{ Form::text('ambar', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('ambar', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('red', 'Rango red (Valor Máximo)',['class' => 'col-sm-4 control-label']) }}<br>
                                        <div class="col-sm-8">
                                            {{ Form::text('red', null, ['class' => 'form-control']) }}
                                            {{ $errors->first('red', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class=" col-sm-12">
                                            <button type="submit" class="btn btn-default btn-sm">GUARDAR</button>
                                        </div>
                                    </div>

                                {{ Form::close() }}

                            </div>
                            <div class="col-md-8">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('mapa')
    <script> $(document).ready(function(){ $('#company_id').change(function(){ $.get("{{ url('getCategoryForCompany')}}", { option: $(this).val() }, function(data) { $('#category_product_id').empty(); $.each(data, function(key, element) { $('#category_product_id').append("<option value='" + key + "'>" + element + "</option>"); }); }); }); }); </script>
@stop