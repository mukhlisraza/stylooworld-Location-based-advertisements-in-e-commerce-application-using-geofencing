<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Thanks</title>
    <link href="{{ url('css/front_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/main.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/responsive.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ url('js/front_js/html5shiv.js') }}"></script>
    <script src="{{ url('js/front_js/respond.min.js') }}"></script>
    <![endif]-->
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/ico/android-icon-192x192.png')}}">

</head>
<!--/head-->

<body>

    <!-- Header Part -->
    @include('layouts.front_layout.front_header')

    <div class="jumbotron text-center">
        <h1 class="display-3">Oops!</h1>

        <p class="lead">Sorry, Requested search product not found!</p>

        <hr>

        <p class="lead">
            <a class="btn btn-primary btn-sm" href="{{url('/')}}" role="button">Continue to homepage</a>
        </p>
    </div>

    <!--/Footer-->
    @include('layouts.front_layout.front_footer')

    <script src="{{ url('js/front_js/jquery.js') }}"></script>
    <script src="{{ url('js/front_js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/front_js/main.js') }}"></script>
</body>

</html>

<php Session::forget('grand_total'); Session::forget('order_id'); ?>