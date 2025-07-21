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
    <title>Order Details</title>
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

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/ico/android-icon-192x192.png')}}">

</head>
<!--/head-->

<body>

    <!-- Header Part -->
    @include('layouts.front_layout.front_header')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{url('/orders')}}">Back &nbsp; </a></li>
                    <li class="active">Order Details</li>
                </ol>
            </div>
            <hr>
            <div class="card-header">
                <h3 class="card-title">Order No# {{$orderDetails['id']}} Details</h3>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-5">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td colspan="2">
                                <strong>Order Details</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Order Date</td>
                            <td>{{date('d-m-Y',strtotime($orderDetails['created_at']))}}</td>
                        </tr>
                        <tr>
                            <td>Order Status</td>
                            <td>{{$orderDetails['order_status']}}</td>
                        </tr>
                        <tr>
                            <td>Order Total</td>
                            <td>Rs. {{$orderDetails['grand_total']}}</td>
                        </tr>
                        <tr>
                            <td>Coupon Code</td>
                            <td>{{$orderDetails['coupon_code']}}</td>
                        </tr>
                        <tr>
                            <td>Coupon Amount</td>
                            <td>{{$orderDetails['coupon_amount']}}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{$orderDetails['payment_gateway']}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-5 pull-right">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <td colspan="2">
                                <strong>Delivery Address</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{$orderDetails['name']}}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{$orderDetails['mobile']}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{$orderDetails['address']}}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{$orderDetails['city']}}</td>
                        </tr>
                        <tr>
                            <td>Pincode</td>
                            <td>{{$orderDetails['pincode']}}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{$orderDetails['country']}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br />

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td colspan="6">
                                <strong>Order Details</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Product Quantity</th>

                        </tr>

                        <tbody>
                            @foreach($orderDetails['orders_products'] as $product)
                            <tr>
                                <td>
                                    <?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                                    <a href="{{url('product/'.$product['product_id'])}}">
                                        <img src="{{ asset('images/product_images/small/'.$getProductImage) }}" class="img-thumbnail" alt="Cinque Terre" title="View Image Details" width="60px">
                                    </a>
                                </td>
                                <td>{{$product['product_code']}}</td>
                                <td>{{$product['product_name']}}</td>
                                <td>{{$product['product_size']}}</td>
                                <td>{{$product['product_color']}}</td>
                                <td>{{$product['product_qty']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <br />
            <br /> <br />
        </div>
    </section>
    <!--/#cart_items-->

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