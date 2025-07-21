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
    </section>

    <!-- Main content -->
    <section class="content">
        @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Orders</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="orders" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Order Products</th>
                                    <th>Order Amount</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($orders as $order)
                                @if($order['order_status']=='Pending')
                                <?php $i++; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{date('d-m-Y',strtotime($order['created_at']))}}</td>
                                    <td>{{$order['name']}}</td>
                                    <td>{{$order['email']}}</td>
                                    <td>
                                        @foreach($order['orders_products'] as $pro)
                                        {{$pro['product_code']}} ({{$pro['product_qty']}})<br />
                                        @endforeach
                                    </td>
                                    <td>{{$order['grand_total']}}</td>
                                    <td>
                                        <span class="badge badge-warning">{{$order['order_status']}}</span>
                                    </td>
                                    <td>{{$order['payment_method']}}</td>
                                    <td style="width:10%;">
                                        <a href="{{url('admin/orders/'.$order['id'])}}" title="View Details">&nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i></a>
                                        &nbsp;&nbsp;
                                        @if($order['order_status']=="Delivered")
                                        <a href="{{url('admin/view-order-invoice/'.$order['id'])}}" target="_blank" title="View Order Invoice">&nbsp;&nbsp;&nbsp;<i class="fas fa-print"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->



</div>
@endsection