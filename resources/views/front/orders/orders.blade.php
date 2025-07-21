<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Orders</title>
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
                    <li><a href="{{url('account')}}">Back &nbsp; </a></li>
                    <li class="active">Recent Order List</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Orders</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">Order ID</th>
                                <th>Order Products</th>
                                <th>Payment Method</th>
                                <th>Grand Total</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Details</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order['id']}}</td>
                                <td>
                                    @foreach($order['orders_products'] as $pro)
                                    {{$pro['product_code']}}<br />
                                    @endforeach
                                </td>
                                <td>Cash On Delivery ({{$order['payment_method']}})</td>
                                <td>Rs. {{$order['grand_total']}}</td>
                                <td>{{date('d-m-Y',strtotime($order['created_at']))}}</td>
                                <td><span class="badge badge-warning"> {{$order['order_status']}}</span></td>
                                <td><a href="{{url('orders/'.$order['id'])}}"> View </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
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