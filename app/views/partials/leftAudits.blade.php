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
                    <li>
                        <a><span class="icon-listausuario"></span> Ingresar Espacios <span class="sr-only">(current)</span></a>
                    </li>
                    <li><a href="{{ route('auditSpaces') }}" >Listar Auditorias de Espacios</a></li>
                    <li><a href="{{ route('insertSpace') }}" >Nueva Configuración de Espacio</a></li>
                    <li class="divider"></li>

                    <li><a href="{{ route('insertPoll') }}"> <span class="icon-nuevousuario"></span>  Encuesta</a></li>
                    <li><a href="{{ route('importStore') }}"> <span class="icon-nuevousuario"></span>  Presencia de Producto</a></li>
                    <li><a href="{{ route('importStore') }}"> <span class="icon-nuevousuario"></span>  Materiales de Exhibición</a></li>
                </ul>
            </div>
        </div><!-- /.container-fluid -->
    </nav>
</div>