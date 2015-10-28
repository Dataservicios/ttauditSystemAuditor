@extends('layouts/adminLayout')
@section('content')
<section>
    @include('company/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <h4>Nueva Empresa</h4>
                    <div class="cuerpo-content">
                        <div class="row">
                            <div class="col-md-12">
                                {{ Form::open(['route' => 'registerCompany', 'method' => 'POST', 'role' => 'form', 'novalidate', 'class' => 'form-horizontal']) }}
                                    <div class="form-group">
                                        {{ Form::label('fullname', 'Nombre', ['class' => 'col-sm-2 control-label']) }}
                                        <div class="col-sm-3">
                                        {{ Form::text('fullname', null, ['class' => 'form-control']) }}
                                        {{ $errors->first('fullname', '<div class="alert alert-danger" role="alert">:message</div>') }}
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class=" col-sm-10">
                                            <button type="submit" class="btn btn-default btn-sm">GUARDAR</button>
                                            <a href="{{ route('listCompanies') }}" ><button type="button" class="btn btn-default btn-sm">CANCELAR</button></a>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                                <form class="form-horizontal" role="form">

                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
@stop