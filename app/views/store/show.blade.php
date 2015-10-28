@extends('layouts/adminLayout')

@section('content')
<section>
    @include('store/partials/menuLeft')
    <div class="cuerpo">
        <div class="cuerpo-content">
            <div class="row">
                <div class="col-md-12">
                    <h4>Punto de Venta</h4>
                    <div class="cuerpo-content">
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Punto: </b> {{ $store->fullname }}</p>
                                <p><b>Tipo:</b>{{ $store->type }}</p>
                                <p><b>Propietario:</b>{{ $store->owner}}</p>
                                <p><b>Dirección:</b>{{ $store->address}}</p>
                                <p><b>Urbanización:</b> {{ $store->urbanization}}</p>
                                <p><b>Distrito:</b> {{ $store->district}}</p>
                                <p><b>Region:</b> {{ $store->region}}</p>
                                <p><b>Ubigeo:</b> {{ $store->ubigeo}}</p>
                                <p><b>Distribuidor:</b> {{ $store->distributor}}</p>

                                <!--<button type="button" class="btn btn-default">VOLVER A LA LISTA</button>-->
                                <a href="{{ route('listStores') }}" class="btn btn-default btn-sm " role="button">VOLVER A LA LISTA</a>
                            </div>
                            <div class="col-md-8">
                                <!-- MAPA CANVAS -->
                                <div id="map_canvas">
                                    <!-- css3 preLoading-->
                                    <div class="mapPerloading"> <span>Cargando</span>
                                        <span class="l-1"></span>
                                        <span class="l-2"></span>
                                        <span  class="l-3"></span>
                                        <span class="l-4"></span>
                                                        <span class="l-5">
                                                        </span>
                                        <span class="l-6"></span>
                                    </div>
                                </div>
                                <!-- END MAPA CANVAS -->
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
    <!-- google maps -->
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
        {{ HTML::script('lib/infobox.min.js'); }}
        {{ HTML::script('js/script-mapa.js'); }}
        <!--  end google maps -->

        <script>
            init('{{ route('storeMap').'?id='.$store->id }}');
        </script>
@endsection