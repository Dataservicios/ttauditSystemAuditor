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

                                {{ Form::open(['route' => 'listSpaceForCompany', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form', 'novalidate']) }}
                                    {{ Form::hidden('audit_id', 1, ['class' => 'form-control', 'placeholder' => 'Nombre']) }}

                                    <div class="form-group">
                                        {{ Form::label('company_id', 'Cliente',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::select('company_id', $combobox, $selected, ['class' => 'form-control']) }}
                                            {{ $errors->first('company_id', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=" col-sm-12">
                                            <button type="submit" class="btn btn-default btn-sm">ENVIAR</button>
                                        </div>
                                    </div>

                                {{ Form::close() }}

                            </div>
                            <div class="col-md-8">

                            </div>
                        </div>

                        @if (isset($spaces))
                        <div class="row">
                            <div class="col-sm-8">
                                <h4>Lista de Auditorias Configuradas <a href="">{{{ $company[0]->fullname }}}</a>  </h4>
                            </div>
                            <div class="col-sm-4">

                            </div>
                        </div>

                        <!--Lista de usuario-->
                        <table class="table-responsive table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>Categoria</th>
                                <th>Verde</th>
                                <th>Ambar</th>
                                <th>Rojo</th>

                                <th class="text-right">Acciones</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $c=0 ?>
                            @foreach ($spaces as $space)
                            <?php $c=$c+1 ?>
                            <tr>
                                <td>{{ $c}}</td>
                                <td><a href="{{ route('storeDetail', [$space->id]) }}">{{ $space->id }}</a></td>
                                <td>{{ $space->categoryProduct->fullname }}</td>
                                <td>{{ $space->green}}</td>
                                <td>{{ $space->ambar }}</td>
                                <td>{{ $space->red }}</td>

                                <td class="text-right">
                                    <a href="" data-toggle="tooltip" data-placement="bottom" title="Editar Usuario"><span class="icon-editarusuario"></span></a>
                                    <a href="{{ route('spaceDetail', [$space->id]) }}" data-toggle="tooltip" data-placement="bottom" title="Ver Resultados">Ver resultados</a>
                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>

                        @endif


                        @if (isset($spaceDetails))
                            <div class="row">
                                <div class="col-sm-8">
                                    <h4>Resultado de auditoria <a href="">{{{ $company[0]->fullname }}}</a>  </h4>
                                </div>
                                <div class="col-sm-4">

                                </div>
                            </div>

                            <!--Lista de usuario-->
                            <table class="table-responsive table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Categoria</th>
                                    <th>Verde</th>
                                    <th>Ambar</th>
                                    <th>Rojo</th>

                                    <th class="text-right">Acciones</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $c=0 ?>
                                @foreach ($spaces as $space)
                                <?php $c=$c+1 ?>
                                <tr>
                                    <td>{{ $c}}</td>
                                    <td><a href="{{ route('storeDetail', [$space->id]) }}">{{ $space->id }}</a></td>
                                    <td>{{ $space->categoryProduct->fullname }}</td>
                                    <td>{{ $space->green}}</td>
                                    <td>{{ $space->ambar }}</td>
                                    <td>{{ $space->red }}</td>

                                    <td class="text-right">
                                        <a href="" data-toggle="tooltip" data-placement="bottom" title="Editar Usuario"><span class="icon-editarusuario"></span></a>

                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>

                        @endif

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