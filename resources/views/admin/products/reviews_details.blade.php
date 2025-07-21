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
                            <h3 class="card-title">Total Reviews &nbsp; &nbsp; <span class="badge badge-primary">{{$totalReview}}</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Rating &nbsp;&nbsp; <span class="badge badge-primary">{{$totalRating}} STARS</span></h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
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
                                        <strong>Reviews</strong>
                                    </td>
                                </tr>
                                <tbody>
                                    @foreach($productReview as $review)
                                    <tr>
                                        <td>
                                            <div class="chip">
                                                <img src="{{asset('images/review/img_avatar.png')}}" alt="Person" width="20" height="20">
                                                &nbsp;&nbsp;{{$review['user_name'] }}&nbsp;&nbsp;&nbsp;<span class="badge badge-success">&nbsp;{{$review['rating']}} / 5</span>
                                            </div>

                                            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$review['review']}}</strong><br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge badge-pill badge-warning">({{date('j F, Y ', strtotime($review['created_at']))}})</span>
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
            </div>
            <br>
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

                                    <th>Section</th>
                                    <th>Category</th>
                                </tr>

                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <?php $getProductImage = Product::getProductImage($product['id']) ?>
                                            <a href="{{url('product/'.$product['id'])}}">
                                                <img src="{{ asset('images/product_images/small/'.$getProductImage) }}" class="img-thumbnail" alt="Cinque Terre" title="View Image Details" width="60px">
                                            </a>
                                        </td>
                                        <td></td>
                                        <td>{{$product['product_name']}}</td>

                                        <td>{{$product['section']['name']}}</td>
                                        <td>{{$product['category']['category_name']}}</td>

                                    </tr>
                                    @endforeach
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