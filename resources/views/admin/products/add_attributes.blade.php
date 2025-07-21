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
                        <li class="breadcrumb-item"><a href="{{url('admin/products')}}">Products</a></li>
                        <li class="breadcrumb-item active">Product Attributes</li>
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
            @if (Session::has('attSuccess_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{Session::get('attSuccess_message') }}
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
            <form name="addAttributeForm" id="addAttributeForm" method="post" action="{{url('admin/add-attributes/'.$productdata['id'])}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{$productdata['id']}}">
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
                                    <label for="product_name">Product Name : </label> &nbsp; {{$productdata['product_name']}}
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <img style="width:120px;" src="{{asset('images/product_images/small/'.$productdata['main_image']) }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="field_wrapper">
                                        <div>
                                            <input id="size" name="size[]" type="text" name="size[]" value="" placeholder="Size" style="width: 120px;" required />
                                            <input id="price" name="price[]" type="number" name="price[]" value="" placeholder="Price" style="width: 120px;" required />
                                            <input id="stock" name="stock[]" type="number" name="stock[]" value="" placeholder="Stock" style="width: 120px;" required />
                                            <a href="javascript:void(0);" class="add_button" title="Add field"><i class="far fa-plus-square"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Attributes</button>
                    </div>
                </div>
            </form>




            <form name="editAttributeForm" id="editAttributeForm" method="post" action="{{url('admin/edit-attributes/'.$productdata['id'])}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Added Product Attributes</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Size</th>

                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Manage Colors</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($productdata['attributes'] as $attribute)
                                <?php $i++; ?>
                                <!-- getting the attribute fields ids  -->
                                <input style="display: none;" type="text" name="attrId[]" value="{{$attribute['id']}}">
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$attribute['size']}}</td>
                                    <td>
                                        <input type="number" name="price[]" value="{{$attribute['price']}}" required="">
                                    </td>
                                    <td>
                                        <input type="number" name="stock[]" value="{{$attribute['stock']}}" required="">
                                    </td>
                                    <td>
                                        <a href="{{url('admin/add-attribute-colors/'.$attribute['id'])}}" title="Add Colors">Add Colors</a>
                                    </td>
                                    <td>
                                        @if($attribute['status']==1)
                                        <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>
                                        @else
                                        <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                        @endif
                                        &nbsp;
                                        <a href="javascript:void(0)" class="confirmDelete" record="attribute" recordid="{{$attribute['id']}}" title="Delete Product"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update Attributes</button>
                    </div>
                </div>
                <!-- /.card -->
            </form>

            <form name="editColorForm" id="editColorForm" method="post" action="{{url('admin/edit-color/'.$productdata['id'])}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Added Product Colors</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($productdata['colors'] as $color)
                                <?php $i++; ?>
                                <!-- getting the attribute fields ids  -->
                                <input style="display: none;" type="text" name="attrId[]" value="{{$color['id']}}">
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$color['size']}}</td>
                                    <td>{{$color['color']}}</td>

                                    <td>
                                        <input type="number" name="stock[]" value="{{$color['stock']}}" required="">
                                    </td>
                                    <td>

                                        &nbsp;
                                        <a href="javascript:void(0)" class="confirmDelete" record="color" recordid="{{$color['id']}}" title="Delete Product"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update Colors</button>
                    </div>
                </div>
                <!-- /.card -->
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection