<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Create a stylish landing page for your business startup and get leads for the offered services with this HTML landing page template.">
    <meta name="author" content="Inovatik">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta property="og:type" content="article" />
 <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CloudMultiple') }}</title>
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <!-- Website Title -->
    <title>Multiple CLoud</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.css') }}"  rel="stylesheet">
    <link href="{{ asset('frontend/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href={{"frontend/css/swiper.css"}} rel="stylesheet">
	<link href={{"frontend/css/magnific-popup.css"}} rel="stylesheet">
	<link href={{"frontend/css/styles.css"}} rel="stylesheet">

	<!-- Favicon  -->
    <link rel="icon" href={{asset("images/favicon.png")}}>
</head>
<body data-spy="scroll" data-target=".fixed-top">

    @include('layouts.homepage.navigation')
    @include('layouts.homepage.header')

    @yield('content')

    {{-- @include('layouts.homepage.footer') --}}


    <!-- Scripts -->
    <script src={{"frontend/js/jquery.min.js"}}></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
    <script src={{"frontend/js/popper.min.js"}}></script> <!-- Popper tooltip library for Bootstrap -->
    <script src={{"frontend/js/bootstrap.min.js"}}></script> <!-- Bootstrap framework -->
    <script src={{"frontend/js/jquery.easing.min.js"}}></script> <!-- jQuery Easing for smooth scrolling between anchors -->
    <script src={{"frontend/js/swiper.min.js"}}></script> <!-- Swiper for image and text sliders -->
    <script src={{"frontend/js/jquery.magnific-popup.js"}}></script> <!-- Magnific Popup for lightboxes -->
    <script src={{"frontend/js/validator.min.js"}}></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
    <script src={{"frontend/js/scripts.js"}}></script> <!-- Custom scripts -->
</body>
</html>
