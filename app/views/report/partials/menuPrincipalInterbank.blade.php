
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
                        @foreach($menus as $menu)
                            @if($menu['active'] == 1)
                                <li class="active"><a href="{{ $menu['url'] }}"> <span class="@if($menu['icon'] == 'inicio') icon-puntoventa @endif @if($menu['icon'] == 'audit') icon-auditoria @endif "></span>  {{$menu['nombre']}}</a></li>
                            @else
                                <li><a href="{{ $menu['url'] }}"> <span class="@if($menu['icon'] == 'inicio') icon-puntoventa @endif @if($menu['icon'] == 'audit') icon-auditoria @endif @if($menu['icon'] == 'materiales') icon-materiales @endif "></span>  {{$menu['nombre']}}</a></li>

                            @endif
                        @endforeach
                    </ul>
                </div>


        </div><!-- /.container-fluid -->
    </nav>
</div>