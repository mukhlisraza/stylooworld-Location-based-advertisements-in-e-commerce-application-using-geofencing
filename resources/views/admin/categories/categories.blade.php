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
                        <li class="breadcrumb-item active">Category</li>
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
                        <h3 class="card-title">All Categories</h3>
                        @if(Auth::guard('admin')->user()->type=='admin')
                        <a href="{{url('admin/add-edit-category')}}"><button type="button" class="btn btn-warning btn-sm float-right"> <i class="far fa-plus-square"></i> Add Category</button></a>
                        @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="categories" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Parent Category</th>
                                    <th>Section</th>
                                    @if(Auth::guard('admin')->user()->type=='admin')
                                    <th>Status</th>
                                    <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($categories as $category)
                                <!-- @if(!isset($category->parentCategory->category_name))
                                {{$parent_Category = "Root" }}
                                @else
                                {{$parent_Category = $category->parentCategory->category_name }}
                                @endif -->
                                <?php $i++; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td>{{$parent_Category}}</td>
                                    <td>{{$category->section->name}}</td>
                                    @if(Auth::guard('admin')->user()->type=='admin')
                                    <td>
                                        @if($category->status==1)
                                        <a class="updateCategoryStatus" id="category-{{$category->id}}" category_id="{{$category->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>
                                        @else
                                        <a class="updateCategoryStatus" id="category-{{$category->id}}" category_id="{{$category->id}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="{{url('admin/add-edit-category/'.$category->id)}}"><i class="fas fa-edit"></i></a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="confirmDelete" record="category" recordid="{{$category->id}}"><i class="far fa-trash-alt text-danger"></i></a>

                                    </td>
                                    @endif
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