<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>REMINDER LIST</title>
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


    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-57-precomposed.png') }}">
</head>
<!--/head-->

<body>

    <!-- Header Part -->
    @include('layouts.front_layout.front_header')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">Reminder List</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <div id="AppendReminderItems">
                    @include('front.products.reminder_items')
                </div>
            </div>
        </div>
    </section>
    <br />
    <br />
    <br />
    <br />
    <!--/#cart_items-->

    <!--/Footer-->
    @include('layouts.front_layout.front_footer')


    <script src="{{ url('js/front_js/jquery.js') }}"></script>
    <script src="{{ url('js/front_js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ url('js/front_js/price-range.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ url('js/front_js/main.js') }}"></script>
    <script src="{{ url('js/front_js/front_script.js') }}" type="text/javascript"></script>

</body>

</html>