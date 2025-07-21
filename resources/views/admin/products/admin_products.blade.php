@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cataglogues</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                        <h3 class="card-title">All Products</h3>
                        <a href="{{url('admin/add-edit-product')}}"><button type="button" class="btn btn-warning btn-sm float-right"> <i class="far fa-plus-square"></i> Add product</button></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>product Name</th>
                                    <th>Category</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($products as $product)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <?php $product_image_path = "images/product_images/small/" . $product->main_image; ?>
                                        @if(!empty($product->main_image) && file_exists($product_image_path))
                                        <img src="{{ asset('images/product_images/small/'.$product->main_image) }}" class="img-thumbnail" alt="Cinque Terre" width="60px">
                                        @else
                                        <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="60px">
                                        @endif
                                    </td>
                                    <td>{{$product->product_name}}</td>


                                    <td>{{$product->category->category_name}}</td>
                                    <td>{{$product->section->name}}</td>
                                    <td>
                                        @if($product->status==1)
                                        <a class="updateProductStatus" id="product-{{$product->id}}" product_id="{{$product->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>

                                        @else
                                        <a class="updateProductStatus" id="product-{{$product->id}}" product_id="{{$product->id}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                        @endif
                                    </td>
                                    <td style="width:10%;">

                                        <a href="{{url('admin/add-attributes/'.$product->id)}}" title="Add/Edit Attributes"><i class="fas fa-plus-square"></i></a>

                                        <a href="{{url('admin/add-edit-product/'.$product->id)}}" title="Edit Product"><i class="fas fa-edit"></i></a>

                                        <a href="{{url('admin/add-images/'.$product->id)}}" title="Add Images"><i class="far fa-images"></i></a>

                                        <a href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{$product->id}}" title="Delete Product"><i class="far fa-trash-alt text-danger"></i></a>

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
@endsection