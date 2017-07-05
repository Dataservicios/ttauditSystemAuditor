<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Template Title -->
	<title>Auditoria de Punto de Venta - TT Audit </title>

	<link rel="icon" href="{{ asset('home/images/favicon.ico') }}">

	<!-- Bootstrap 3.2.0 stylesheet -->
	<link rel="stylesheet" href="{{ asset('home/css/bootstrap.min.css') }}">

	<!-- Font Awesome Icon stylesheet -->
	<link rel="stylesheet" href="{{ asset('home/css/font-awesome.min.css') }}">

	<!-- Owl Carousel stylesheet -->
	<link rel="stylesheet" href="{{ asset('home/css/owl.carousel.css') }}">

	<!-- Pretty Photo stylesheet -->
	<link rel="stylesheet" href="{{ asset('home/css/prettyPhoto.css') }}">

	<!-- Custom stylesheet -->
	<link rel="stylesheet" href="{{ asset('home/style.css') }}">

	<link rel="stylesheet" href="{{ asset('home/css/color/white.css') }}">

	<!-- Custom Responsive stylesheet -->
	<link rel="stylesheet" href="{{ asset('home/css/responsive.css') }}">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
@yield('content')

{{ HTML::script('http://code.jquery.com/jquery.min.js'); }}
{{ HTML::script('home/js/jquery.js'); }}

<!-- Modernizr js -->
{{ HTML::script('home/js/modernizr-latest.js'); }}

<!-- Bootstrap 3.2.0 js -->
{{ HTML::script('home/js/bootstrap.min.js'); }}

<!-- Owl Carousel plugin -->
{{ HTML::script('home/js/owl.carousel.min.js'); }}

<!-- ScrollTo js -->
{{ HTML::script('home/js/jquery.scrollto.min.js'); }}

<!-- LocalScroll js -->
{{ HTML::script('home/js/jquery.localScroll.min.js'); }}

<!-- jQuery Parallax plugin -->
{{ HTML::script('home/js/jquery.parallax-1.1.3.js'); }}

<!-- Skrollr js plugin -->
{{ HTML::script('home/js/skrollr.min.js'); }}

<!-- jQuery One Page Nav Plugin -->
{{ HTML::script('home/js/jquery.nav.js'); }}

<!-- jQuery Pretty Photo Plugin -->
{{ HTML::script('home/js/jquery.prettyPhoto.js'); }}


<!-- Custom JS -->
{{ HTML::script('home/js/main.js'); }}

<script>
	jQuery(document).ready(function($) {
		"use strict";

		jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({social_tools:false});
	});
</script>
</body>
</html>