@extends('layouts/adminLayout')
@section('content')
<section>
    @include('partials/leftAudits')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <h3>Auditoria Preguntas por Cliente</h3>
                    <div class="cuerpo-content">

                        <div class="row">
                            <div class="col-md-4">

                                {{ Form::open(['route' => 'insertPoll', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form', 'novalidate']) }}
                                    {{--{{ Form::hidden('audit_id', 1, ['class' => 'form-control', 'placeholder' => 'Nombre']) }}--}}

                                    <div class="form-group">
                                        {{ Form::label('company', 'Cliente',['class' => 'col-sm-4 control-label']) }}
                                        <div class="col-sm-8">
                                            {{ Form::select('company', $combobox, $selected, ['class' => 'form-control']) }}
                                            {{ $errors->first('company', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>
                                    </div>
                                    @if (isset($_GET['company']))
                                        {{ Form::hidden('company_id', $_GET['company'], ['class' => 'form-control', 'placeholder' => 'Nombre']) }}
                                        <div class="form-group">
                                            <h4>Cliente {{ $company[0]->fullname }} cuestionario</h4>
                                            {{ Form::label('question', 'Ingresar Pregunta',['class' => 'col-sm-4 control-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text('question', null, ['class' => 'form-control']) }}
                                                {{ $errors->first('question', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class=" col-sm-12">
                                                <button type="submit" class="btn btn-default btn-sm">GUARDAR</button>
                                            </div>
                                        </div>
                                    @endif

                                {{ Form::close() }}
                                @if (isset($questions))
                                    <table class="table-responsive table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Fecha Creación</th>

                                            <th class="text-right">Acciones</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $c=0 ?>
                                        @foreach ($questions as $question)
                                        <?php $c=$c+1 ?>
                                            <tr>
                                                <td>{{ $c}}</td>
                                                <td><a href="users-info.html">{{ $question->id }}</a></td>
                                                <td ><a href="users-info.html">{{ $question->question }}</a></td>
                                                <td>{{ $question->created_at }}</td>

                                                <td class="text-right">
                                                    <a href="" data-toggle="tooltip" data-placement="bottom" title="Editar Pregunta"><span class="icon-editarusuario"></span></a>

                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                @endif

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
<script>
    $(function(){
      // bind change event to select
      $('#company').bind('change', function () {
          var url = "{{ route('insertPoll') }}" + "?company=" +$(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
@stop
