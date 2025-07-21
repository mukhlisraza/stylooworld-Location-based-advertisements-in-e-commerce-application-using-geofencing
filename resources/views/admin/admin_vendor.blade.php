@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vendor Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Vendor</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
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
            <div class="row">
                <div class="card col-md-12 m-auto">
                    <div class="card-header">
                        <h3 class="card-title">Vendor / All</h3>
                        <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="far fa-plus-square"></i> Register Vendor</button>

                        <!-- Modal -->

                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Register Vendor</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">
                                            <form action="{{url('admin/vendor-registration')}}" method="post" id="verdorRegisterForm" class="col-md-10 m-auto">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name">Business Name:</label>
                                                    <input type="text" id="business_name" name="business_name" class="form-control" placeholder="Enter Business Name..." required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Business Address:</label>
                                                    <input type="text" id="business_address" name="business_address" class="form-control" placeholder="Enter Business Address..." required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Full Name:</label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name..." required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mobile">Phone:</label>
                                                    <input type="number" id="phone" name="phone" class="form-control" placeholder="Phone Number..." required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mobile">Email:</label>
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email..." required>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Register</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>

                                    <th>Business Name</th>
                                    <th>Business Address</th>
                                    <th>Contact</th>
                                    <th>Account Status</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($vendorDetails as $vendor)
                                @if($vendor['type']=='vendor')
                                <?php $i++; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$vendor['name']}}</td>

                                    <td>
                                        {{$vendor['business_name']}}
                                    </td>
                                    <td>
                                        {{$vendor['business_address']}}
                                    </td>

                                    <td>{{$vendor['mobile']}}</td>
                                    <td>
                                        &nbsp;&nbsp;
                                        @if($vendor['status']==1)
                                        <span class="badge badge-primary">Active</span>
                                        @else
                                        <span class="badge badge-danger">Blocked</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($vendor['status']==1)
                                        <a class="updateVendorStatus" id="vendor-{{$vendor['id']}}" vendor_id="{{$vendor['id']}}" title="Account Active" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>

                                        @else
                                        <a class="updateVendorStatus" id="vendor-{{$vendor['id']}}" vendor_id="{{$vendor['id']}}" title="Account Block" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                        @endif
                                        &nbsp;&nbsp;
                                        <a href="#" data-toggle="tooltip" class="confirmDelete" record="vendor" recordid="{{$vendor['id']}}" title="Delete Product"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>
                                @endif
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
<script src="{{ url('js/admin_js/profile.js') }}"></script>
@endsection