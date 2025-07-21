@extends('layouts.admin_layout.admin_layout')
@section('content')

<link rel="stylesheet" href="{{ url('css/admin_css/profile.css') }}">

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
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/products')}}">Products</a></li>
                        <li class="breadcrumb-item active">Product Images</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (Session::has('error_message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="row">
                <div class="col-md-4 m-auto">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">


                                @if(!empty($productdata['main_image']) && file_exists("images/product_images/small/" . $productdata['main_image']))
                                <img src="{{ asset('images/product_images/small/'.$productdata['main_image'])}}" class="img-thumbnail" alt="Cinque Terre" width="150px">
                                @else
                                <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="150px">
                                @endif

                            </div>
                            <br />
                            <h3 class="profile-username text-center">{{$productdata['product_name']}}</h3>

                            <p class="text-muted text-center">Price: {{$productdata['product_price']}}</p>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->


                <div class="card col-md-7">
                    <div class="card-header">
                        <h3 class="card-title">Gallery Picture</h3>
                        <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="far fa-plus-square"></i> Add Gallery Image</button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <!-- //Form -->
                                <form name="addImagesForm" id="addImagesForm" method="post" action="{{url('admin/add-images/'.$productdata['id'])}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add Gallery Image</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-8 m-auto">
                                                    <p>Click on the "Choose File" button to upload a file:</p>

                                                    <input type="file" id="images" name="images[]" value="" multiple="" accept="image/*">

                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal" role="form" action="{{url('/admin/update-image')}}" name="updateImages" id="updateImage" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($productdata['images'] as $image)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            <img style="width:120px;" src="{{asset('images/product_images/small/'.$image['image']) }}" alt="">
                                        </td>
                                        <td>
                                            @if($image['status']==1)
                                            <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>

                                            @else
                                            <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                            @endif
                                            &nbsp;
                                            <a href="javascript:void(0)" class="confirmDelete" record="image" recordid="{{$image['id']}}" title="Delete Product"><i class="far fa-trash-alt text-danger"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection