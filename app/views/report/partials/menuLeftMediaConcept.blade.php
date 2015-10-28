
<div class="zona-menu-left">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            @if ($userType == 'company')
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
                        <li><a href="{{ route('auditReport', "12/1244") }}">  Encuesta Mercado Ciudad de Dios</a></li>
                        <li><a href="{{ route('auditReport', "12/1245") }}">  Encuesta Mercado Valle Sagrado</a></li>
                        <li><a href="{{ route('auditReport', "12/1246") }}">  Encuesta Mercado Virgen de las Mercedes</a></li>
                    </ul>
                </div>
            @endif

        </div><!-- /.container-fluid -->
    </nav>
</div>