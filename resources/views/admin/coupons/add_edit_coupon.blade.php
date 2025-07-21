@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Coupons</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid col-md-12 m-auto">
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
            @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form name="couponForm" id="couponForm" @if(empty($coupon['id'])) action="{{url('admin/add-edit-coupon')}}" @else action="{{url('admin/add-edit-coupon/'.$coupon['id'])}}" @endif method="post" enctype="multipart/form-data">
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
                            <div class="col-md-12">
                                @if(empty($coupon['coupon_code']))
                                <div class="form-group">
                                    <label for="coupon_option">Coupon Option</label><br />
                                    <span>
                                        <input type="radio" id="AutomaticCoupon" name="coupon_option" value="Automatic" checked=""> Automatic &nbsp;&nbsp;
                                    </span>
                                    <span>
                                        <input type="radio" id="ManaulCoupon" name="coupon_option" value="Manual"> Manual &nbsp;&nbsp;
                                    </span>
                                </div>
                                <div class="form-group" style="display: none;" id="couponField">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter coupon code">
                                </div>
                                @else
                                <input type="hidden" name="coupon_option" value="{{$coupon['coupon_option']}}">
                                <input type="hidden" name="coupon_code" value="{{$coupon['coupon_code']}}">
                                <div class="form-group">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input type="text" class="form-control" name="coupon_code" id="coupon_code" value="{{$coupon['coupon_code']}}" disabled>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="coupon_type">Coupon Type</label><br />
                                    <span>
                                        <input type="radio" name="coupon_type" value="Multiple Times" @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=="Multiple Times" ) checked="" @elseif(!isset($coupon['coupon_type'])) checked="" @endif> &nbsp; Multiple Times &nbsp;&nbsp;
                                    </span>
                                    <span>
                                        <input type="radio" name="coupon_type" value="Single Times" @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=="Single Times" ) checked="" @endif> &nbsp; Single Times &nbsp;&nbsp;
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="amount_type">Amount Type</label><br />
                                    <span>
                                        <input type="radio" name="amount_type" value="Percentage" @if(isset($coupon['amount_type']) && $coupon['amount_type']=="Percentage" ) checked="" @elseif(!isset($coupon['amount_type'])) checked="" @endif> &nbsp; Percentage &nbsp; ( in % ) &nbsp;
                                    </span>
                                    <span>
                                        <input type="radio" name="amount_type" value="Fixed" @if(isset($coupon['amount_type']) && $coupon['amount_type']=="Fixed" ) checked="" @elseif(!isset($coupon['amount_type'])) checked="" @endif> &nbsp; Fixed &nbsp; ( in PKR ) &nbsp;
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount (% / pkr)</label><br />
                                    <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter amount" required @if(isset($coupon['amount'])) value="{{$coupon['amount']}}" @endif>

                                </div>
                                <div class="form-group">
                                    <label for="categories">Select Categories</label>
                                    <select name="categories[]" id="categories[]" multiple="" class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach($categories as $section)
                                        <optgroup label="{{$section['name']}}"></optgroup>
                                        @foreach($section['categories'] as $category)
                                        <!-- added code at option code is to back the data again if form is incorrect so data remain in the field -->
                                        <option value="{{$category['id']}}" @if(in_array($category['id'],$setCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$category['category_name']}}</option>
                                        @foreach($category['subcategories'] as $subcategory)
                                        <option value="{{$subcategory['id']}}" @if(in_array($subcategory['id'],$setCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;->&nbsp;&nbsp;{{$subcategory['category_name']}}</option>
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="users">Select Users [optional]</label>
                                    <select name="users[]" id="users[]" multiple="" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach($users as $user)
                                        <option value="{{$user['email']}}" @if(in_array($user['email'],$setUsers)) selected="" @endif>{{$user['email']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date" class="form-control" name="expiry_date" id="expiry_date" placeholder="Enter expiry date" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask required @if(isset($coupon['expiry_date'])) value="{{$coupon['expiry_date']}}" @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" style="width: 30%;"> {{$title}} </button>
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