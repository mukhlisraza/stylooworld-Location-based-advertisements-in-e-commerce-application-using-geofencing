@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Banners</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Banners</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid col-md-12">
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
            <form name="bannerForm" id="bannerForm" @if(empty($banner['id'])) action="{{url('admin/add-edit-banner')}}" @else action="{{url('admin/add-edit-banner/'.$banner['id'])}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{$title}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Banner Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter Banner Title Max:100 Character" @if(!empty($banner['title'])) value="{{$banner['title']}}" @else value="{{old('title')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label for="alt">Banner Alternative Text</label>
                                    <input type="text" class="form-control" name="alt" id="alt" placeholder="Enter Banner Alternative Words" @if(!empty($banner['alt'])) value="{{$banner['alt']}}" @else value="{{old('alt')}}" @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Banner Description</label>
                                    <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description Max:200 Characters" @if(!empty($banner['description'])) value="{{$banner['description']}}" @else value="{{old('description')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label for="link">Banner Link</label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter Banner Link" @if(!empty($banner['link'])) value="{{$banner['link']}}" @else value="{{old('link')}}" @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Banner Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <!-- <input type="file" class="custom-file-input" id="main_image" name="main_image"> -->
                                            <input type="file" class="form-control" accept="image/*" id="image" name="image" @if(!empty($banner['image'])) value="{{$banner['image']}}" @else value="{{old('image')}}" @endif>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="form-text text-muted pt-2">Product image dimensions must be: <kbd>width: 484px</kbd> &amp; <kbd>height: 441px</kbd> and format <code>jpeg, jpg, png.</code></small>
                                    </div>
                                    @if(!empty($banner['image']))
                                    <div>
                                        <img style="width:80px; margin-top:5px;" src="{{asset('images/banner_images/'.$banner['image']) }}" alt="">
                                        &nbsp;
                                        <a href="javascript:void(0)" class="confirmDelete" record="banner-image" recordid="{{$banner['id']}}"> Delete Image </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    </br>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection