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
                        <li class="breadcrumb-item active">Product Color</li>
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

            <form name="addColorForm" id="addColorForm" method="post" action="{{url('admin/add-colors/'.$productdata['id'])}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{$productID->product_id}}">
                <input type="hidden" name="product_attribute_size" value="{{$productdata['size']}}">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Add Product Colors</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="field_wrapper1">
                                        <div>
                                            <input id="color" name="size[]" type="text" name="size[]" value="" placeholder="Color" style="width: 120px;" required />
                                            <input id="stock" name="stock[]" type="number" name="stock[]" value="" placeholder="Stock" style="width: 120px;" required />
                                            <a href="javascript:void(0);" class="addColor_button" title="Add field"><i class="far fa-plus-square"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Colors</button>
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
                                    <th>#</th>
                                    <th>Size</th>
                                    <th>Colors</th>
                                    <th>Stock</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>

                                <?php $i++; ?>
                                <td>{{$i}}</td>
                                <td>{{$productdata['size']}}</td>
                                <td>
                                    @foreach($attributeColor as $color)
                                    <i class="fa fa-arrow-right"></i> {{$color->color}} &nbsp;
                                    (<a href="javascript:void(0)" class="confirmDelete" record="color" recordid="{{$color->id}}" title="Delete Color"><i class="far fa-trash-alt text-danger"></i></a>)
                                    <br />
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($attributeColor as $color)
                                    <i class="fa fa-arrow-right"></i> {{$color->stock}}
                                    <br />
                                    @endforeach
                                </td>
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


        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection