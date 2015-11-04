<div class="zona-menu-left">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluidxxxxxx">
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
                    <li class="active"><a href="{{ route('listStores') }}"> <span class="icon-listausuario"></span> Listar Puntos <span class="sr-only">(current)</span></a></li>
                    <li><a href="{{ route('newStore') }}"> <span class="icon-nuevousuario"></span>  Nuevo Punto</a></li>
                    <li><a href="{{ URL::to('http://ttaudit.com/rutas-auditor/index.html') }}" target="_blank"> <span class="icon-nuevousuario"></span>  Crear rutas</a></li>
                    <li><a href="{{ route('listRoads') }}"> <span class="icon-nuevousuario"></span>  Listar Rutas</a></li>
                </ul>
            </div>
        </div><!-- /.container-fluid -->
    </nav>
</div>