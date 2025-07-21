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
    <title>Checkout</title>
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
    <form action="{{url('/checkout')}}" method="post" name="checkoutForm" id="checkoutForm">
        @csrf
        <section id="cart_items">
            <div class="container">
                <br />
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('/cart')}}">Cart</a></li>
                        <li class="active">Check out</li>

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

                <hr class="soft" />
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2"> <strong> DELIVERY ADDRESSES | </strong> &nbsp; <a href="{{url('add-edit-delivery-address')}}"> <i class="fa fa-plus-square"></i> Add </a></td>

                    </tr>

                    @foreach($deliveryAddresses as $address)
                    <tr>
                        <td>
                            <div class="control-group">
                                <input type="radio" id="address{{$address['id']}}" name="address_id" value="{{$address['id']}}"> &nbsp;&nbsp;
                                <label class="control-label">{{$address['name']}}, {{$address['address']}},
                                    {{$address['city']}}, ({{$address['pincode']}}), {{$address['country']}}.
                                </label>
                            </div>
                        </td>
                        <td style="text-align:center;"><a href="{{url('add-edit-delivery-address/'.$address['id'])}}">Edit</a> | <a href="{{url('delete-delivery-address/'.$address['id'])}}" class="addressDelete">Delete</a></td>
                    </tr>
                    @endforeach
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script>
                        // Delete Delivery Address
                        $(document).on('click', '.addressDelete', function() {
                            var result = confirm("Want to delete this address!");
                            if (!result) {
                                return false;
                            }
                        });
                    </script>
                </table>

                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu_checkout">
                                <td class="image"><b>Image</td>
                                <td><b>Title</td>
                                <td><b>Size</td>
                                <td><b>Color</td>
                                <td style="width:13%; text-align:center;"><b>Quantity</td>
                                <td style="width:8%;"><b>Price</td>
                                <td style="width:8%;"><b>Discount</td>
                                <td style="width:8%;"><b>Sub Total</td>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_price = 0; ?>
                            @foreach($userCartItems as $item)
                            <?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']); ?>
                            <tr>
                                <td class="cart_product">

                                    <?php $product_image_path = "images/product_images/small/" . $item['product']['main_image']; ?>
                                    @if(!empty($item['product']['main_image']) && file_exists($product_image_path))
                                    <img src="{{ asset('images/product_images/small/'.$item['product']['main_image']) }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                                    @else
                                    <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                                    @endif

                                </td>
                                <td class="cart_description">
                                    <h4><a class="replacetext" href="">{{$item['product']['product_name']}}</a></h4>

                                </td>
                                <td class="cart_price">
                                    <p>{{$item['size']['size']}}</p>
                                </td>
                                <td class="cart_price">
                                    <p>{{$item['color']['color']}}</p>
                                </td>
                                <td class="cart_price">
                                    <p style="text-align: center;">{{$item['quantity']}}</p>
                                </td>

                                <td class="cart_total">
                                    <p class="cart_total_price">Rs. {{$attrPrice['product_price'] * $item['quantity']}}</p>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">Rs. {{$attrPrice['discount'] * $item['quantity']}}</p>
                                </td>
                                <td class="cart_total">

                                    <p class="cart_total_price">Rs. {{$attrPrice['final_price'] * $item['quantity']}}</p>
                                </td>

                            </tr>
                            <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']); ?>
                            @endforeach
                            <tr>
                                <td colspan="7" class="cart_calculation">Total Price:</td>
                                <td class="cart_calculation_right">Rs. {{$total_price}}</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="cart_calculation">Delivery Charges:</td>
                                <td class="cart_calculation_right" style="color: green;"> FREE </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="cart_calculation">Coupon Discount:</td>
                                <td class="couponAmount cart_calculation_right">
                                    @if(Session::has('couponAmount'))
                                    Rs. {{Session::get('couponAmount')}}
                                    @else
                                    Rs. 0
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="cart_calculation">TOTAL:(Rs. {{$total_price}} - <span class="couponAmount">@if(Session::has('couponAmount')) Rs. {{Session::get('couponAmount')}} @else Rs. 0 @endif</span> ) = </td>

                                <td id="total_calculation" class="grand_total">
                                    Rs. {{ $grand_total = $total_price - Session::get('couponAmount')}}
                                    <?php Session::put('grand_total', $grand_total); ?>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!--/#cart_items-->

        <section id="do_action">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="total_area">
                            <ul>
                                <li>
                                    <label for="">PAYEMENT METHOD:</label><br /><br />
                                    <input type="radio" name="payment_gateway" id="COD" value="COD" class="col-sm-4"> <strong>Cash On Delivery</strong> (COD)
                                </li>
                            </ul>
                            <a class="btn btn-default check_out" href="{{url('/cart')}}"><i class="fa fa-angle-double-left"></i> Back To Cart</a>
                            <button type="submit" class="btn btn-default check_out pull-right"> Place Order <i class="fa fa-angle-double-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <!--/#do_action-->
    <php Session::forget('couponAmount'); ?>
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