
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
                        @if($audit_id=='')
                            <li class="active"><a href="{{ route('report') }}"> <span class="icon-nuevousuario"></span> Inicio</a></li>
                            @else
                            <li><a href="{{ route('report') }}"> <span class="icon-nuevousuario"></span> Inicio</a></li>
                        @endif
                        @foreach($AuditsCompany as $audits)
                            @if($audits->id==2)
                                @if($audits->id == $audit_id)
                                    <li class="active"><a href="{{ route('auditReportPresencia', $audits->id) }}"> <span class="icon-listausuario"></span>  {{$audits->fullname}}</a></li>
                                @else
                                    <li><a href="{{ route('auditReportPresencia', $audits->id) }}"> <span class="icon-nuevousuario"></span>  {{$audits->fullname}}</a></li>
                                @endif
                            @endif
                            @if($audits->id==3)
                                @if($audits->id == $audit_id)
                                    <li class="active"><a href="{{ route('auditReportVisibilidad', $audits->id) }}"> <span class="icon-listausuario"></span>  {{$audits->fullname}}</a></li>
                                @else
                                    <li><a href="{{ route('auditReportVisibilidad', $audits->id) }}"> <span class="icon-nuevousuario"></span>  {{$audits->fullname}}</a></li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>


        </div><!-- /.container-fluid -->
    </nav>
</div>