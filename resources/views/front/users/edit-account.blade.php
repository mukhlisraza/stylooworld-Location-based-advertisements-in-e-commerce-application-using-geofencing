@extends('layouts.front_layout.front_layout')
@section('content')




<section id="editprofilesection">
    <div class="container">
        <h3>Edit Profile</h3>

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
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <hr>
        <div class="row">
            <!-- left column -->
            <div class="col-md-3">
                <div class="text-center">

                    @if(!empty($userDetails['image']))
                    <img src="{{  asset('images/user_images/'.$userDetails['image'].".jpg") }}" alt="" class="img-thumbnail" alt="Cinque Terre" width="130px">
                    @else
                    <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="130px">
                    @endif

                    <h6>Upload a different photo...</h6>
                    <form class="form-horizontal" role="form" action="{{url('/update-user-image')}}" name="updateUserImage" id="updateUserImage" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="user_image" id="user_image" accept="image/*">
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary pull-left" value="Update">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- edit form column -->
            <div class="col-md-5 personal-info">
                <h3>Personal info.</h3>
                <form id="accountForm" class="form-horizontal" action="{{url('/editaccount')}}" method="post" role="form">
                    @csrf
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Name:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="{{$userDetails['name']}}" id="name" name="name" pattern="[a-zA-Z]+">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Mobile:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="{{$userDetails['mobile']}}" id="mobile" name="mobile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Address:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="{{$userDetails['address']}}" id="address" name="address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Country:</label>
                        <div class="col-lg-8">

                            <select id="country" name="country">
                                <option value="">Selection Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country['country_name']}}" @if($country['country_name']==$userDetails['country']) selected="" @endif>{{$country['country_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">City:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="{{$userDetails['city']}}" id="city" name="city">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Pincode:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="{{$userDetails['pincode']}}" id="pincode" name="pincode">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary" value="Update">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- left column -->
            <div class="col-md-4">
                <h3>Update Password</h3>
                <form class="form-horizontal" role="form" id="passwordForm" action="{{url('/update-user-pwd')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="{{$userDetails['email']}}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Current Password:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="password" placeholder="Enter New Password" value="" name="current_pwd" id="current_pwd" required>
                            <b><span id="chkPwd"></span></b>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">New password:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="password" value="" placeholder="New Password" name="new_pwd" id="new_pwd" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Confirm password:</label>
                        <div class="col-md-8">
                            <input class="form-control" type="password" value="" placeholder="Confirm Password" name="confirm_pwd" id="confirm_pwd" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
</section>

@endsection