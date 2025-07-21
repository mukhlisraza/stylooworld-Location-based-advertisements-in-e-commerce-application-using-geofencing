<?php

use App\Product;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CART</title>
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



    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-144-precomposed.jpg') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-114-precomposed.jpg') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-72-precomposed.jpg') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-57-precomposed.jpg') }}">
</head>
<!--/head-->

<body>

    <!-- Header Part -->
    @include('layouts.front_layout.front_header')

    <section id="cart_items">
        <div class="container">
            <br />
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart ( <span class="totalCartItems"> {{ totalCartItems()   }} </span>)</li>
                </ol>
            </div>
            @if (Session::has('error_message'))
            <div class="alert alert-danger " role="alert">
                {{Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (Session::has('success_message'))
            <div class="alert alert-success " role="alert">
                {{Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="table-responsive cart_info">
                <div id="AppendCartItems">
                    @include('front.products.cart_items')
                </div>
            </div>
        </div>
    </section>
    <!--/#cart_items-->

    <section id="do_action">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="total_area">

                        <form id="ApplyCoupon" method="post" action="javascript:void(0);" class="form-horizontal" @if(Auth::check()) user="1" @endif>
                            @csrf
                            <ul>
                                <li>
                                    <label for="">COUPON CODE:</label>

                                    <input type="text" name="code" id="code" class="form-control" placeholder="Enter Coupon Code" class="col-sm-4" required>
                                    <br>
                                    <button type="submit" class="btn btn-warning"> Apply </button>
                                </li>
                            </ul>
                        </form>



                        <!-- ************************* Coupon Functionality ********************* -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                        <script>
                            // Apply Coupon
                            $("#ApplyCoupon").submit(function() {

                                // alert("Test");
                                // return false;
                                var user = $(this).attr("user");
                                if (user == 1) {
                                    //do nothing
                                } else {
                                    alert("Please login to apply coupon!");
                                    return false;
                                }
                                var code = $("#code").val();
                                // alert(code);
                                $.ajax({
                                    type: 'post',
                                    data: {
                                        code: code
                                    },
                                    url: '/apply-coupon',
                                    success: function(resp) {
                                        if (resp.message != "") {
                                            alert(resp.message);
                                        }
                                        $(".totalCartItems").html(resp.totalCartItems + " Items");
                                        $("#AppendCartItems").html(resp.view);
                                        if (resp.couponAmount >= 0) {
                                            $(".couponAmount").text("Rs. " + Math.round(resp.couponAmount));
                                        } else {
                                            $(".couponAmount").text("Rs. 0");
                                        }
                                        if (resp.grand_total >= 0) {
                                            $(".grand_total").text("Rs. " + Math.round(resp.grand_total));
                                        }

                                    },
                                    error: function() {
                                        alert("Error");
                                    }
                                });
                            })
                        </script>








                        <a class="btn btn-default check_out" href="{{url('/')}}"><i class="fa fa-angle-double-left"></i> Back To Shopping</a> <a class="btn btn-default check_out pull-right" href="{{url('checkout')}}">Check Out <i class="fa fa-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#do_action-->

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