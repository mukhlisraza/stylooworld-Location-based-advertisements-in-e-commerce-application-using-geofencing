<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KIRMAAN</title>
    <link href="{{ url('css/front_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/main.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/profileaccount.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/responsive.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/front-responsive.min.css') }}" rel="stylesheet" />
    <!-- <link id="callCss" rel="stylesheet" href="{{ url('css/front_css/front.min.css') }}" media="screen" /> -->
    <!--[if lt IE 9]>
    <script src="{{ url('js/front_js/html5shiv.js') }}"></script>
    <script src="{{ url('js/front_js/respond.min.js') }}"></script>
    <![endif]-->
    <!-- Google-code-prettify -->

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="192x192" style="object-fit:scale-down" href="{{ asset('images/ico/android-icon-192x192.png')}}">


    <link href="{{ url('js/front_js/google-code-prettify/prettify.css') }}" rel="stylesheet" />

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/front_images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/front_images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/front_images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/front_images/ico/apple-touch-icon-57-precomposed.png') }}">
</head>
<!--/head-->

<body>

    <!-- Header Part -->
    @include('layouts.front_layout.front_header')

    @if(isset($page_name) && $page_name=='index')
    @include('front.banners.home_page_banner')
    @endif

    <!-- Main Content Along With Side Bar -->

    @yield('content')

    <!--/Footer-->
    @include('layouts.front_layout.front_footer')


    <script src="{{ url('js/front_js/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ url('js/front_js/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ url('js/front_js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ url('js/front_js/price-range.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ url('js/front_js/main.js') }}"></script>
    <script src="{{ url('js/front_js/front.js') }}"></script>
    <script src="{{ url('js/front_js/google-code-prettify/prettify.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.lightbox-0.5.js') }}"></script>
    <script src="{{ url('js/front_js/front.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('js/front_js/front_script.js') }}" type="text/javascript"></script>

</body>

</html>