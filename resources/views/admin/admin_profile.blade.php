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
                    <a href="{{ url('/admin/profile')}}">
                        <h1>Profile</h1>
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
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
                            <a href="{{url('/admin/update-admin-details')}}">
                                <p class="text-center text-primary"> Edit </p>
                            </a>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#exampleModalCenter">
                                Change Avatar
                            </button>

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
                                                        <input class="form-control" type="file" name="admin_avatar_image" id="admin_avatar_image" accept="image/*">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
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
                                <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="profile">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <!-- use another method to fectch the data from database -->
                                                <input class="form-control" value="{{$adminDetails->name}}" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" value="{{$adminDetails->email}}" readonly="">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <!-- Check the value tage it's the another way to access the data -->
                                                <input class="form-control" value="{{Auth::guard('admin')->user()->mobile}}" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Business name</label>
                                            <div class="col-sm-10">
                                                <!-- Check the value tage it's the another way to access the data -->
                                                <input class="form-control" value="{{Auth::guard('admin')->user()->business_name}}" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Business address</label>
                                            <div class="col-sm-10">
                                                <!-- Check the value tage it's the another way to access the data -->
                                                <input class="form-control" value="{{Auth::guard('admin')->user()->business_address}}" readonly="">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <!-- SETTING PAGE -->

                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
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


                                @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif

                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal" role="form" action="{{url('/admin/update-current-pwd')}}" name="updatePasswordForm" id="updatePasswordForm" method="post">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" value="{{Auth::guard('admin')->user()->email}}" readonly="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Current Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="current_pwd" class="form-control" id="current_pwd" placeholder="Enter current password" required>
                                                <span id="chkCurrentPwd"></span>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">New Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="new_pwd" class="form-control" id="new_pwd" placeholder="Enter new password" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Confirm Password:</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="confirm_pwd" class="form-control" id="confirm_pwd" placeholder="Enter confirm password" required>
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