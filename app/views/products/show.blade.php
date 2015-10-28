@extends('layouts/adminLayout')
@section('content')
<section>
    @include('store/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <h4>Producto Información</h4>
                    <div class="cuerpo-content">
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Producto:</b> {{ $product->fullname }}</p>
                                <p><b>Compañia:</b> <a href="{{ route('company', [$product->company->id]) }}">
                                                        {{ $product->company->fullname }}
                                                    </a></p>
                                <p><b>Precio:</b>{{ $product->precio }}</p>
                                <p><b>EAM:</b>{{ $product->eam }}</p>
                                <p>
                                   <b>Categoria:</b> <a href="{{ route('category', [$product->categoryProduct->id]) }}">{{ $product->categoryProduct->fullname }}</a>
                                </p>

                                <!--<button type="button" class="btn btn-default">VOLVER A LA LISTA</button>-->
                                <a href="#" class="btn btn-default btn-sm " role="button">VOLVER A LA LISTA</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
@stop