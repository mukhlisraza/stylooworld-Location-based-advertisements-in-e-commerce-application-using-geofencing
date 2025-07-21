<?php

use Carbon\Carbon;
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
                    <h1>Coupons</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
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
                        <h3 class="card-title">All Coupons</h3>
                        <a href="{{url('admin/add-edit-coupon')}}"><button type="button" class="btn btn-warning btn-sm float-right"> <i class="far fa-plus-square"></i> Add coupon</button></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="sections" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Coupon Type</th>
                                    <th>Amount</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{$coupon['id']}}</td>
                                    <td>{{$coupon['coupon_code']}}</td>
                                    <td>{{$coupon['coupon_type']}}</td>
                                    <td>
                                        {{$coupon['amount']}}
                                        @if($coupon['amount_type']=="Percentage")
                                        %
                                        @else
                                        PKR
                                        @endif
                                    </td>
                                    <td>{{$coupon['expiry_date']}}</td>
                                    <td>

                                        @if($coupon['expiry_date']>$today_date && $coupon['status']==0)
                                        <span class="badge badge-warning">Not Published</span>
                                        @elseif($coupon['expiry_date']>$today_date)
                                        <span class="badge badge-success">Publish</span>
                                        @elseif($coupon['expiry_date'] < $today_date) <span class="badge badge-danger">Expired</span>
                                            @else
                                            <span class="badge badge-warning">Not Published</span>
                                            @endif
                                    </td>
                                    <td style="width: 10%;">
                                        @if($coupon['status']==1)
                                        <a class="updateCouponstatus" id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>
                                        @else
                                        <a class="updateCouponstatus" id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                        @endif
                                        <a href="{{url('admin/add-edit-coupon/'.$coupon['id'])}}" title="Edit coupon"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="confirmDelete" record="coupon" recordid="{{$coupon['id']}}" title="Delete coupon"><i class="far fa-trash-alt text-danger"></i></a>

                                    </td>

                                </tr>
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
<!-- /.content-wrapper -->


@endsection