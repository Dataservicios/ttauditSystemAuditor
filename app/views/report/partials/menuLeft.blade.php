
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
                        @if($audit_id=="0")
                            <li class="active"><a href="{{ route('report') }}">  Inicio</a></li>
                            @else
                            <li><a href="{{ route('report') }}">  Inicio</a></li>
                        @endif

                        @if ($CantidadStoresAudits<>0)
                            @if($audit_id=="excel")
                                <li class="active"><a href="{{ route('reportExcel') }}"> <span class="icon-listausuario"></span>  Reportes en Excel</a></li>
                            @else
                                <li><a href="{{ route('reportExcel') }}"> <span class="icon-listausuario"></span>  Reportes en Excel</a></li>
                            @endif
                        @endif


                        @foreach($AuditsCompany as $audits)
                            @if($audits->id == $audit_id)
                                    <li class="active"><a href="{{ route('auditReport', $audits->id) }}"> <span class="icon-listausuario"></span>  {{$audits->fullname}}</a></li>
                                @else
                                    @if ($CantidadStoresAudits<>0)
                                        <li><a href="{{ route('auditReport', $audits->id) }}"> <span class="icon-nuevousuario"></span>  {{$audits->fullname}}</a></li>
                                        @else
                                        <li><a href=""> <span class="icon-nuevousuario"></span>  {{$audits->fullname}}</a></li>
                                    @endif

                            @endif

                        @endforeach
                            @if ($CantidadStoresAudits<>0)
                                @if(($audit_id=='audios') and ($audit_id<>0))
                                    <li class="active"><a href="{{ route('reportAudios') }}"> <span class="icon-listausuario"></span>  Lista de audios</a></li>
                                @else
                                    <li><a href="{{ route('reportAudios') }}"> <span class="icon-listausuario"></span>  Lista de audios</a></li>
                                @endif
                            @endif


                    </ul>
                </div>
            @endif

        </div><!-- /.container-fluid -->
    </nav>
</div>