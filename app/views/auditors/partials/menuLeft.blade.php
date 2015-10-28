
<div class="zona-menu-left">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand" href="#">Brand</a>-->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if($opcion=='1')
                        <li class="active"><a href="{{ route('auditorClient', 1,1) }}"> Encuestas Interbank Ola 1</a></li>
                        @else
                        <li><a href="{{ route('auditorClient', 1,1) }}"> Encuestas Interbank Ola 1</a></li>
                    @endif
                    @if($opcion=='2')
                            <li class="active"><a href="{{ route('auditorClient', 8,2) }}"> Encuestas Interbank Ola 2</a></li>
                        @else
                            <li><a href="{{ route('auditorClient', 8,2) }}"> Encuestas Interbank Ola 2</a></li>
                    @endif
                    <li><a href="{{ URL::to('http://ttaudit.com/rutas-auditor/index.html') }}" target="_blank"> Crear Rutas</a></li>
                    <li><a href="{{ route('listStores') }}"> Lista de Puntos</a></li>


                    <li><a href="{{ route('responsePoll', "6/12/1244") }}">  Encuesta Mercado Ciudad de Dios</a></li>
                    <li><a href="{{ route('responsePoll', "6/12/1245") }}">  Encuesta Mercado Valle Sagrado</a></li>
                    <li><a href="{{ route('responsePoll', "6/12/1246") }}">  Encuesta Mercado Virgen de las Mercedes</a></li>
                </ul>
            </div>

        </div><!-- /.container-fluid -->
    </nav>
</div>