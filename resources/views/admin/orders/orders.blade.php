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
                        @if(Auth::guard('admin')->user()->type == 'vendor')
                        <table id="orders" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Customer Name</th>

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
                                @if(!empty($order['orders_products']))
                                <?php $i++; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$order['order_id']}}</td>
                                    <td>{{date('d-m-Y',strtotime($order['created_at']))}}</td>
                                    <td>{{$order['name']}}</td>

                                    <td>
                                        @foreach($order['orders_products'] as $pro)
                                        {{$pro['product_code']}} ({{$pro['product_qty']}})<br />
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($order['orders_products'] as $pro)
                                        {{$pro['product_price']*$pro['product_qty']}}
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($order['order_status']=="Delivered")
                                        <span class="badge badge-success">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="New")
                                        <span class="badge badge-primary">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="In Process")
                                        <span class="badge badge-secondary">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="Cancelled")
                                        <span class="badge badge-danger">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="Delivered to Store")
                                        <span class="badge badge-info">{{$order['order_status']}}</span>
                                        @else
                                        <span class="badge badge-warning">{{$order['order_status']}}</span>
                                        @endif


                                    </td>
                                    <td>{{$order['payment_method']}}</td>
                                    <td style="width:10%;">
                                        <a href="{{url('admin/orders/'.$order['id'])}}" title="View Details">&nbsp;&nbsp;&nbsp;<i class="fas fa-file-alt"></i></a>
                                        &nbsp;&nbsp;
                                        @if($order['order_status']=="Delivered" && Auth::guard('admin')->user()->type == 'admin')
                                        <a href="{{url('admin/view-order-invoice/'.$order['id'])}}" target="_blank" title="View Order Invoice">&nbsp;&nbsp;&nbsp;<i class="fas fa-print"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table id="orders" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Customer Name</th>
                                    <th>Customer Mobile</th>
                                    <th>Order Products</th>
                                    <th>Order Amount</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($ordersAdmin as $order)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$order['order_id']}}</td>
                                    <td>{{date('d-m-Y',strtotime($order['created_at']))}}</td>
                                    <td>{{$order['name']}}</td>
                                    <td>{{$order['mobile']}}</td>
                                    <td>
                                        @foreach($order['orders_products'] as $pro)
                                        {{$pro['product_code']}} ({{$pro['product_qty']}})<br />
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$order['grand_total']}}
                                    </td>
                                    <td>
                                        @if($order['order_status']=="Delivered")
                                        <span class="badge badge-success">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="New")
                                        <span class="badge badge-primary">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="In Process")
                                        <span class="badge badge-secondary">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="Cancelled")
                                        <span class="badge badge-danger">{{$order['order_status']}}</span>
                                        @elseif ($order['order_status']=="Delivered to Store")
                                        <span class="badge badge-info">{{$order['order_status']}}</span>
                                        @else
                                        <span class="badge badge-warning">{{$order['order_status']}}</span>
                                        @endif


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
                                @endforeach
                            </tbody>
                        </table>
                        @endif
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