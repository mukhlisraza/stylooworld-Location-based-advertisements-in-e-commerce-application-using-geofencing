<?php

use App\Product;

?>
@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </section>

    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">

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
                                    <td>
                                        @if(Auth::guard('admin')->user()->type == 'vendor')
                                        @foreach($orderDetails['orders_products'] as $product)
                                        Rs. {{$product['product_price']*$product['product_qty']}}
                                        @endforeach
                                        @elseif(Auth::guard('admin')->user()->type == 'admin')
                                        Rs. {{$orderDetails['grand_total']}}
                                        @endif
                                    </td>
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
                    </div>

                    @if(Auth::guard('admin')->user()->type == 'admin')
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Delivery Address</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
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
                                <tr>
                                    <td>Special Note</td>
                                    <td>{{$orderDetails['special_note']}}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <!-- /.card -->
                    @elseif(Auth::guard('admin')->user()->type == 'vendor')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Delivery Address</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Name</td>
                                    <td>kirmaan store</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td>03159521076</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>City center, saddar, Rawalpindi</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>Rawalpindi</td>
                                </tr>

                                <tr>
                                    <td>Country</td>
                                    <td>Pakistan</td>
                                </tr>
                                <tr>
                                    <td>Special Note</td>
                                    <td>Product Should be same as display</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    @endif

                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    @if(Auth::guard('admin')->user()->type == 'admin')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Name</td>
                                    <td>{{$userDetails['name']}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$userDetails['email']}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Billing Address</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Name</td>
                                    <td>{{$userDetails['name']}}</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td>{{$userDetails['mobile']}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{$userDetails['address']}}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{$userDetails['city']}}</td>
                                </tr>
                                <tr>
                                    <td>Pincode</td>
                                    <td>{{$userDetails['pincode']}}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{$userDetails['country']}}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <!-- /.card -->
                    @endif
                    @if(Auth::guard('admin')->user()->type == 'admin')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Updated Order status</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <form action="{{url('admin/update-order-status')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$orderDetails['id']}}">
                                        <td colspan="2">
                                            <select name="order_status" id="" class="form-control select2">
                                                <option value="" disabled selected>Select Status</option>
                                                @if(Auth::guard('admin')->user()->type == 'vendor')
                                                @foreach($orderStatus as $status)
                                                <option value="{{$status['name']}}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected @endif>{{$status['name']}}</option>
                                                @endforeach
                                                @else
                                                @foreach($orderStatusAdmin as $status)
                                                <option value="{{$status['name']}}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected @endif>{{$status['name']}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            &nbsp;
                                            <br />

                                            <button type="submit" class="btn btn-warning btn-sm float-right">Updated Status</button>
                                        </td>
                                    </form>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @foreach($orderLog as $log)
                                        <br>
                                        <strong>{{$log['order_status']}}</strong><br>
                                        {{ date('j F, Y (g:i a)', strtotime($log['created_at']))}}
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    @endif
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table">
                                <tr>
                                    <td colspan="6">
                                        <strong>Product Details</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Image</th>

                                    <th>Product Name</th>
                                    <th>Product Size</th>
                                    <th>Product Color</th>
                                    <th>Product Quantity</th>

                                </tr>

                                <tbody>
                                    @if(Auth::guard('admin')->user()->type == 'vendor')
                                    @foreach($orderDetails['orders_products'] as $product)
                                    <tr>
                                        <td>
                                            <?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                                            <a href="{{url('product/'.$product['product_id'])}}">
                                                <img src="{{ asset('images/product_images/small/'.$getProductImage) }}" class="img-thumbnail" alt="Cinque Terre" title="View Image Details" width="60px">
                                            </a>
                                        </td>

                                        <td>{{$product['product_name']}}</td>
                                        <td>{{$product['product_size']}}</td>
                                        <td>{{$product['product_color']}}</td>
                                        <td>{{$product['product_qty']}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    @foreach($orderDetailsAdmin['orders_products'] as $product)
                                    <tr>
                                        <td>
                                            <?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                                            <a href="{{url('product/'.$product['product_id'])}}">
                                                <img src="{{ asset('images/product_images/small/'.$getProductImage) }}" class="img-thumbnail" alt="Cinque Terre" title="View Image Details" width="60px">
                                            </a>
                                        </td>

                                        <td>{{$product['product_name']}}</td>
                                        <td>{{$product['product_size']}}</td>

                                        <td>{{$product['product_qty']}}</td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



</div>
@endsection