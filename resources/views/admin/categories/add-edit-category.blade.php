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
                        <li class="breadcrumb-item active">Category</li>
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
            @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form name="categoryForm" id="categoryForm" @if(empty($categorydata['id'])) action="{{url('admin/add-edit-category')}}" @else action="{{url('admin/add-edit-category/'.$categorydata['id'])}}" @endif method="post" enctype="multipart/form-data">
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
                                    <label for="category_name">Category Name (*)</label>
                                    <input type="text" class="form-control" name="category_name" id="category_id" placeholder="Enter Category Name" @if(!empty($categorydata['category_name'])) value="{{$categorydata['category_name']}}" @else value="{{old('category_name')}}" @endif>
                                </div>

                                <div id="appendCategoriesLevel">
                                    @include('admin.categories.append_categories_level')
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Section (*)</label>
                                    <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach($getSections as $section)
                                        @if($section['status'] == '1')
                                        <option value="{{ $section->id }}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected @endif> {{$section->name}} </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category_discount">Category Discount (*)</label>
                                    <input type="number" class="form-control" id="category_discount" name="category_discount" placeholder="Enter Category Name" @if(!empty($categorydata['category_discount'])) value="{{$categorydata['category_discount']}}" @else value="{{old('category_discount')}}" @endif>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-12 col-sm-6">


                                <div class="form-group">
                                    <label for="description">Category Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter...">@if(!empty($categorydata['discription'])) {{$categorydata['discription']}} @else {{old('discription') }} @endif</textarea>

                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6">

                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <textarea id="meta_title" name="meta_title" class="form-control" rows="3" placeholder="Enter...">@if(!empty($categorydata['meta_title'])) {{$categorydata['meta_title']}} @else {{old('meta_title') }} @endif</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3">@if(!empty($categorydata['meta_description'])) {{$categorydata['meta_description']}} @else {{old('meta_description') }} @endif</textarea>
                                </div>

                            </div>
                            <div class="col-12 col-sm-6">

                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="3" placeholder="Enter ...">@if(!empty($categorydata['meta_keywords'])) {{$categorydata['meta_keywords']}} @else {{old('meta_keywords') }} @endif</textarea>
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