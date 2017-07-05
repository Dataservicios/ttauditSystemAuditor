
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
                                @if($company_id==1)
                                    @if ( $audit_id =='Interbank-Ola1' )
                                        <li class="active"><a href="{{ route('reportAudios' , 'Interbank-Ola1') }}"> <span class="icon-listausuario"></span>  Lista de audios IBK Ola1</a></li>
                                    @else
                                        <li><a href="{{ route('reportAudios' , 'Interbank-Ola1') }}"> <span class="icon-listausuario"></span>  Lista de audios IBK Ola1</a></li>
                                    @endif
                                @endif

                                @if($company_id==8)
                                        @if ( $audit_id =='Interbank-Ola2' )
                                            <li class="active"><a href="{{ route('reportAudios' , 'Interbank-Ola2') }}"> <span class="icon-listausuario"></span>  Lista de audios IBK Ola2</a></li>
                                        @else
                                            <li><a href="{{ route('reportAudios' , 'Interbank-Ola2') }}"> <span class="icon-listausuario"></span>  Lista de audios IBK Ola2</a></li>
                                        @endif
                                @endif


                            @endif


                    </ul>
                </div>
            @endif

        </div><!-- /.container-fluid -->
    </nav>
</div>