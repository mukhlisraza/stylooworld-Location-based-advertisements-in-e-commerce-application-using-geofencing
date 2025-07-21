<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Notifications</title>
    <link href="{{ url('css/front_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/main.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/notification.css') }}" rel="stylesheet">
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

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <div class="container">

        <div class="mail-box">

            <aside class="lg-side">
                <div class="inbox-head">

                    <h3><i class="fa fa-bell"></i>&#9;Notifications<span class="badge badge-warning">

                            @if(!empty($couponAvailable))
                            {{$couponAvailable}}
                            @else
                            0
                            @endif

                        </span></h3>

                </div>
                <div class="inbox-body">

                    <table class="table table-inbox table-hover">
                        @if(!empty($coupon))
                        @foreach($coupon as $coupons)
                        <tr>
                            <td class="inbox-small-cells">
                                <span class="label label-info ">Ad</span>
                            </td>
                            <td class="view-message">Currently
                                @if($coupons['amount_type'] == 'Fixed')
                                <strong>
                                    Rs. {{$coupons['amount']}}
                                </strong>
                                OFF on
                                @foreach($categoriesDetails as $categoryArray)
                                [{{$categoryArray['category_name']}}]
                                @endforeach
                                categories. Hurry up to get opportunities.

                                @else
                                <strong>
                                    {{$coupons['amount']}} %
                                </strong> OFF on
                                @foreach($categoriesDetails as $categoryArray)
                                [{{$categoryArray['category_name']}}]
                                @endforeach
                                categories. Hurry up to get opportunities.
                                @endif
                            </td>
                            <td class="view-message text-right"><strong> [{{$coupons['coupon_code']}}]</strong></td>
                            <td class="view-message text-right" style="width: 12%;"><strong>[{{$coupons['expiry_date']}}]</strong></td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="inbox-small-cells">
                            <td>
                                <span class="label label-info">No Notification</span>
                            </td>
                        </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
            </aside>
        </div>
    </div>
    <!--/Footer-->
    @include('layouts.front_layout.front_footer')


    <script src="{{ url('js/front_js/jquery.js') }}"></script>
    <script src="{{ url('js/front_js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ url('js/front_js/price-range.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ url('js/front_js/main.js') }}"></script>

</body>

</html>