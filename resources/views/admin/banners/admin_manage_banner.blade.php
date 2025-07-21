@extends('layouts.admin_layout.admin_layout')
@section('content')

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<link rel="stylesheet" href="{{ url('css/admin_css/product.css') }}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Banners</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Manage Banners</li>
                    </ol>
                </div>
                <br />

            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="row">
                <div class="card col-md-12 m-auto">
                    <div class="card-header">
                        <h3 class="card-title">All Banners</h3>
                        <a href="{{url('admin/add-edit-banner')}}">
                            <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#addslider"> <i class="far fa-plus-square"></i> Add Banner</button>
                        </a>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th style="width: 10%;">Link</th>
                                    <th style="width: 10%;">Alt</th>
                                    <th style="width: 40px; text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banner as $banners)
                                <tr>
                                    <td>{{$banners->id}}.</td>
                                    <td>
                                        <img src="{{asset('images/banner_images/'.$banners['image'])}}" class="img-thumbnail" width="60px" alt="">
                                    </td>
                                    <td>
                                        {{$banners->title}}
                                    </td>
                                    <td>{{$banners->description}} </td>
                                    <td>
                                        {{$banners->link}}
                                    </td>
                                    <td>
                                        {{$banners->alt}}
                                    </td>
                                    <td style="width: 11%;">
                                        @if($banners->status==1)
                                        <a class="updateBannerStatus" id="banners-{{$banners->id}}" banners_id="{{$banners->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>
                                        @else
                                        <a class="updateBannerStatus" id="banners-{{$banners->id}}" banners_id="{{$banners->id}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                        @endif
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="{{url('admin/add-edit-banner/'.$banners->id)}}"><i class="fas fa-edit"></i></a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="confirmDelete" record="banners" recordid="{{$banners->id}}"><i class="far fa-trash-alt text-danger"></i></a>

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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        <br />
    </section>
    <!-- /.content -->

</div>


<script src="{{ url('js/admin_js/product.js') }}"></script>
<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>


@endsection