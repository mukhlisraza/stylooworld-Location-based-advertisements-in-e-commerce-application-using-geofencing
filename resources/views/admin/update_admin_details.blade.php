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

                    <h1>Profile</h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>

                        <li class="breadcrumb-item active"> <a href="/admin/profile">User Profile</a></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if(Auth::guard('admin')->user()->type=='admin')
                                <img class="profile-user-img img-fluid img-circle" src="{{url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}}" alt="User profile picture">
                                @else
                                <img class="profile-user-img img-fluid img-circle" src="{{url('images/admin_images/admin_photos/vendor_photos/'.Auth::guard('admin')->user()->image)}}" alt="User profile picture">
                                @endif
                            </div>
                            @php
                            {{
                                $fullname = Auth::guard('admin')->user()->name;
        
                            }}
                            @endphp
                            <h3 class="profile-username text-center">
                                @php
                                {{ echo $fullname;}}
                                @endphp
                            </h3>

                            <p class="text-muted text-center">
                                @php
                                echo Auth::guard('admin')->user()->type;
                                @endphp
                            </p>



                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <form class="form-horizontal" role="form" action="{{url('/admin/update-admin-image')}}" name="updateAdminDetails" id="updateAdminDetails" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Profile Avatar</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-8 m-auto">
                                                        <p>Click on the "Choose File" button to upload a file:</p>

                                                        <input class="form-control" type="file" name="admin_avatar_image" id="admin_avatar_image" accept="image/*" required>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Save Changes</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->


            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Edit Profile</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- SETTING PAGE -->

                            @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{Session::get('error_message') }}
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


                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="tab-pane active" id="edit">
                                <form class="form-horizontal" role="form" action="{{url('/admin/update-admin-details')}}" name="updateAdminDetails" id="updateAdminDetails" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" value="{{Auth::guard('admin')->user()->email}}" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Type:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" value="{{Auth::guard('admin')->user()->type}}" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Business Name:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" value="{{Auth::guard('admin')->user()->business_name}}" name="business_name" id="business_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">business_address:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" value="{{Auth::guard('admin')->user()->business_address}}" name="business_address" id="business_address">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Name:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" value="{{Auth::guard('admin')->user()->name}}" name="admin_name" id="admin_name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Mobile:</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" value="{{Auth::guard('admin')->user()->mobile}}" name="admin_mobile" id="admin_mobile">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Image:</label>
                                        <div class="col-sm-10">

                                            <input class="form-control" type="file" name="admin_image" id="admin_image" accept="image/*">
                                            @if(!empty(Auth::guard('admin')->user()->image) && Auth::guard('admin')->user()->type=='admin')
                                            <a target="_blank" href="{{url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}}">View Image</a>
                                            <input type="hidden" name="current_admin_image" value="{{Auth::guard('admin')->user()->image}}">
                                            @else
                                            <a target="_blank" href="{{url('images/admin_images/admin_photos/vendor_photos/'.Auth::guard('admin')->user()->image)}}">View Image</a>
                                            <input type="hidden" name="current_admin_image" value="{{Auth::guard('admin')->user()->image}}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-warning">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- END SETTING PAGE -->
                            <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection