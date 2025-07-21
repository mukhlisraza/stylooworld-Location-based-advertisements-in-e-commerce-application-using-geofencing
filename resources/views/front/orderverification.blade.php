<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ORDER</title>
    <link href="{{ url('css/front_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/main.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/login.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/responsive.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ url('js/front_js/html5shiv.js') }}"></script>
    <script src="{{ url('js/front_js/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ asset('images/front_images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-57-precomposed.png') }}">
</head>
<!--/head-->

<body>

    <!-- Header Part -->
    @include('layouts.front_layout.front_header')
    <section class="loginsignsec">
        <section id="orderverification">
            <div class="login-card">
                <h1>Verification Code</h1>
                <h5>Please Enter Code Send To Your Mobile Number to Confirm the Order.</h5>

                <form>

                    <input type="number" name="user" placeholder="Enter Code">

                    <br />
                    <input type="submit" name="code" class="btn btn-warning" value="Confirm" id="loginbtn">

                </form>

                <div class="login-help">
                    Didn't Receive Code :
                    <a href="#">Re-send</a><br />

                </div>
            </div>

        </section>
        <!--/Footer-->
        @include('layouts.front_layout.front_footer')


        <script src="{{ url('js/front_js/jquery.js') }}"></script>
        <script src="{{ url('js/front_js/bootstrap.min.js') }}"></script>
        <script src="{{ url('js/front_js/jquery.scrollUp.min.js') }}"></script>
        <script src="{{ url('js/front_js/price-range.js') }}"></script>
        <script src="{{ url('js/front_js/jquery.prettyPhoto.js') }}"></script>
        <script src="{{ url('js/front_js/main.js') }}"></script>
    </section>
</body>

</html>