<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>System Auditor</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-touch-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('favicons/apple-touch-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-touch-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon-180x180.png') }}">
    <link rel="icon" type="image/png" href="{{asset('favicons/favicon-192x192.png')}}" sizes="192x192">
    <link rel="icon" type="image/png" href="{{asset('favicons/favicon-160x160.png')}}" sizes="160x160">
    <link rel="icon" type="image/png" href="{{asset('favicons/favicon-96x96.png')}}" sizes="96x96">
    <link rel="icon" type="image/png" href="{{asset('favicons/favicon-16x16.png')}}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{asset('favicons/favicon-32x32.png')}}" sizes="32x32">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="{{asset('favicons/mstile-144x144.png')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesheet.min.css') }}">
    <!-- StyleSheey mapagoogle-->
    <link rel="stylesheet" href="{{ asset('css/mapa-styles.css') }}"/>
    @yield('reportCSS')
</head>
<body>

<div class="container-full-width">
    @yield('content')


    <footer>

    </footer>
</div>
{{ HTML::script('lib/jquery.min.js'); }}
{{ HTML::script('js/scrollspy.js'); }}
{{ HTML::script('js/dropdown.js'); }}
{{ HTML::script('js/collapse.js'); }}
{{ HTML::script('js/alert.js'); }}
{{ HTML::script('js/tooltip.js'); }}
{{ HTML::script('js/modal.js'); }}
{{ HTML::script('lib/bootstrap.min.js'); }}
{{ HTML::script('assets/js/admin.js') }}

@yield('mapa')

@yield('report')

<script>
    $(function () {

        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
@yield('scripts_angular')
@yield('scripts_ajax')
<script>

    $('.prueba').on( "click", function( event ) {
        event.preventDefault();
        console.log('hola');
    });

</script>

</body>
</html>