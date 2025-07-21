@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Catelogues</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Product</li>
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
            @if (Session::has('error_message'))
            <div class="alert alert-danger " role="alert">
                {{Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (Session::has('success_message'))
            <div class="alert alert-success " role="alert">
                {{Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('flash_message_success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (Session::has('error_message'))
            <div class="alert alert-danger " role="alert">
                {{Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (Session::has('success_message'))
            <div class="alert alert-success " role="alert">
                {{Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <form name="productForm" id="productForm" @if(empty($productdata['id'])) action="{{url('admin/add-edit-product')}}" @else action="{{url('admin/add-edit-product/'.$productdata['id'])}}" @endif method="post" enctype="multipart/form-data">
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
                                    <label>Select Category (*)</label>
                                    <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach($categories as $section)
                                        <optgroup label="{{$section['name']}}"></optgroup>
                                        @foreach($section['product_categories'] as $category)
                                        <!-- added code at option code is to back the data again if form is incorrect so data remain in the field -->
                                        <option value="{{$category['id']}}" @if(!empty(@old('category_id')) && $category['id']==@old('category_id')) selected="" @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$category['id']) selected="" @endif>&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$category['category_name']}}</option>
                                        @foreach($category['subcategories'] as $subcategory)
                                        <option value="{{$subcategory['id']}}" @if(!empty(@old('category_id')) && $subcategory['id']==@old('category_id')) selected="" @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$subcategory['id']) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->&nbsp;&nbsp;{{$subcategory['category_name']}}</option>
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Brand (*)</label>
                                    <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        <!-- displing fabric array that we have created in ProductController-->
                                        @foreach($brands as $brand)
                                        <option value="{{$brand['id']}}" @if(!empty($productdata['brand_id']) && $productdata['brand_id']==$brand['id']) selected="" @endif>{{$brand['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_price">Product Sale Price (*)</label>
                                    <input type="number" class="form-control" name="product_price" id="product_price" placeholder="Enter product Price" @if(!empty($productdata['product_price'])) value="{{$productdata['product_price']}}" @else value="{{old('product_price')}}" @endif>
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_name">Product Name (*)</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter product Name" @if(!empty($productdata['product_name'])) value="{{$productdata['product_name']}}" @else value="{{old('product_name')}}" @endif>
                                </div>

                                <div class="form-group">
                                    <label for="product_Actual_price">Product Actual Price (*)</label>
                                    <input type="number" class="form-control" name="product_Actual_price" id="product_Actual_price" placeholder="Enter product Price" @if(!empty($productdata['product_actual_price'])) value="{{$productdata['product_actual_price']}}" @else value="{{old('product_actual_price')}}" @endif>
                                </div>
                                <div class="form-group">
                                    <label for="product_weight">Product Weight (*)</label>
                                    <input type="number" class="form-control" name="product_weight" id="product_weight" placeholder="Enter product weight" @if(!empty($productdata['product_weight'])) value="{{$productdata['product_weight']}}" @else value="{{old('product_weight')}}" @endif>
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="main_image">Product Main Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <!-- <input type="file" class="custom-file-input" id="main_image" name="main_image"> -->

                                            <input class="custom-file-label col-12" type="file" id="main_image" name="main_image" accept="image/*">
                                        </div>
                                    </div>
                                    <div>
                                        <small class="form-text text-muted pt-2">Product image dimensions must be: <kbd>width: 1080px</kbd> &amp; <kbd>height: 1920px</kbd> and format <code>jpeg, jpg, png.</code></small>
                                    </div>
                                    @if(!empty($productdata['main_image']))
                                    <div>
                                        <img style="width:80px; margin-top:5px;" src="{{asset('images/product_images/small/'.$productdata['main_image']) }}" alt="">
                                        &nbsp;
                                        <a href="javascript:void(0)" class="confirmDelete" record="product-image" recordid="{{$productdata['id']}}"> Delete Image </a>
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Product Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter ...">@if(!empty($productdata['description'])) {{$productdata['description']}} @else {{old('description') }} @endif</textarea>
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="product_video">Product Video</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <!-- <input type="file" class="custom-file-input" id="main_image" name="main_image"> -->
                                            <input class="custom-file-label col-12" type="file" id="product_video" name="product_video" accept="video/*">
                                        </div>
                                    </div>
                                    @if(!empty($productdata['product_video']))
                                    <div>
                                        <a href="{{url('videos/product_videos/'.$productdata['product_video'])}}" download>Download
                                            &nbsp; | &nbsp;
                                            <a href="javascript:void(0)" class="confirmDelete" record="product-video" recordid="{{$productdata['id']}}"> Delete Video </a></a>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="wash_care">Wash Care</label>
                                    <textarea class="form-control" id="wash_care" name="wash_care" rows="3" placeholder="Enter ...">@if(!empty($productdata['wash_care'])) {{$productdata['wash_care']}} @else {{old('wash_care') }} @endif</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">Keywords</label>
                                    <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="3" placeholder="Enter ...">@if(!empty($productdata['meta_keywords'])) {{$productdata['meta_keywords']}} @else {{old('meta_keywords') }} @endif</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="is_featured">Featured Item</label>

                                    <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if(!empty($productdata['is_featured']) && $productdata['is_featured']=="Yes" ) checked="" @endif>
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
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection