
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
                            @if(($menu['url'] <> '') or (count($menu['submenu1'])>0))
                                @if($menu['active'] == 1)
                                    @if(($audit_id==0) or ($audit_id==14))
                                        <li class="active"><a href="{{ $menu['url'] }}"> <span class="@if($menu['icon'] == 'menos') glyphicon glyphicon-minus @endif @if($menu['icon'] == 'inicio') icon-puntoventa @endif @if($menu['icon'] == 'audit') icon-auditoria @endif "></span>  {{$menu['nombre']}}</a>
                                            @if(count($menu['submenu1'])>0)
                                                <ul class="sub">
                                                    @foreach($menu['submenu1'] as $submenu)
                                                        @if($submenu['nombre']<>'')
                                                            @if($submenu['active']==1)
                                                                <li class="active"><a href="{{ $submenu['url'] }}"><span class="@if($menu['icon'] == 'ok') glyphicon glyphicon-ok @endif @if($menu['icon'] == 'inicio') icon-puntoventa @endif @if($menu['icon'] == 'audit') icon-auditoria @endif "></span> {{ $submenu['nombre'] }}</a></li>
                                                            @else
                                                                <li><a href="{{ $submenu['url'] }}"><span class="@if($menu['icon'] == 'ok') glyphicon glyphicon-ok @endif @if($menu['icon'] == 'inicio') icon-puntoventa @endif @if($menu['icon'] == 'audit') icon-auditoria @endif "></span> {{ $submenu['nombre'] }}</a></li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @else
                                        <li class="active"><a href="{{ $menu['url'] }}"> <span class="@if($menu['icon'] == 'mas') glyphicon-plus @endif @if($menu['icon'] == 'inicio') icon-puntoventa @endif @if($menu['icon'] == 'audit') icon-auditoria @endif "></span>  {{$menu['nombre']}}</a></li>
                                    @endif
                                @else
                                    @if($menu['icon'] == 'materiales')
                                        <li><a href="{{ $menu['url'] }}" target="_blank"> <span class="icon-materiales"></span>  {{$menu['nombre']}}</a></li>
                                        @else
                                        <li><a href="{{ $menu['url'] }}"> <span class="@if($menu['icon'] == 'inicio') icon-puntoventa @endif @if($menu['icon'] == 'audit') icon-auditoria @endif @if($menu['icon'] == 'mas') glyphicon glyphicon-plus @endif"></span>  {{$menu['nombre']}}</a></li>
                                    @endif

                                @endif
                            @else
                                <li><a  href="#"> <span class="@if($menu['icon'] == 'listado') icon-listausuario @endif"></span> {{$menu['nombre']}} <span class="sr-only">(current)</span></a></li>
                            @endif

                        @endforeach
                    </ul>
                </div>


        </div><!-- /.container-fluid -->
    </nav>
</div>