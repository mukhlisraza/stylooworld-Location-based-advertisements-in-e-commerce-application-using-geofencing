<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CART</title>
    <link href="{{ url('css/front_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/main.css') }}" rel="stylesheet">
    <link href="{{ url('css/front_css/responsive.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ url('js/front_js/html5shiv.js') }}"></script>
    <script src="{{ url('js/front_js/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/ico/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/ico/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/ico/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/ico/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/ico/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/ico/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/ico/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/ico/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/ico/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/ico/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/ico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/ico/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/ico/favicon-16x16.png') }}">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-144-precomposed.jpg') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-114-precomposed.jpg') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-72-precomposed.jpg') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/front_images/front_images/front_images/ico/apple-touch-icon-57-precomposed.jpg') }}">
</head>
<!--/head-->

<body>

    <!-- Header Part -->
    @include('layouts.front_layout.front_header')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/cart')}}">Cart</a></li>
                    <li><a href="{{url('/checkout')}}">Check out</a></li>
                    <li class="active">Delivery Address</li>
                </ol>
            </div>
            <!--/breadcrums-->

            <div class="step-one">
                <h2 class="heading">{{$title}}</h2>
            </div>
            <!--/checkout-options-->
            @if($errors->any())
            <div class="alert alert-danger" style="margin-top:10px;">
                <ul>
                    @foreach($errors->all() as $errors)
                    <li>
                        {{$errors}}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="shopper-informations">
                <div class="row">
                    <form @if(empty($address['id'])) action="{{url('/add-edit-delivery-address')}}" @else action="{{url('/add-edit-delivery-address/'.$address['id'])}}" @endif id="deliveryAddressForm" method="post">
                        @csrf
                        <div class="col-lg-12">
                            <div class="register-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Name" @if(!empty($address['name'])) value="{{$address['name']}}" @else value="{{old('name')}}" @endif required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="address" id="address" placeholder="Enter Address" @if(!empty($address['name'])) value="{{$address['address']}}" @else value="{{old('address')}}" @endif required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <input class="form-control" type="text" id="city" name="city" placeholder="Enter City" @if(!empty($address['city'])) value="{{$address['city']}}" @else value="{{old('city')}}" @endif required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="number" placeholder="Enter Mobile No." id="mobile" name="mobile" @if(!empty($address['mobile'])) value="{{$address['mobile']}}" @else value="{{old('mobile')}}" @endif required>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Select Country</label>
                                        <select id="country" name="country" required>
                                            <option value="">Selection Country</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country['country_name']}}" @if($country['country_name']==$address['country']) selected @elseif($country['country_name']==old('country')) selected @endif>{{$country['country_name']}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6">
                                        <label>CNIC</label>
                                        <input class="form-control" type="number" placeholder="Enter cnic." id="cnic" name="cnic" @if(!empty($address['cnic'])) value="{{$address['cnic']}}" @else value="{{old('cnic')}}" @endif>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Pincode [optional]</label>
                                        <input class="form-control" type="number" placeholder="Enter pincode." id="pincode" name="pincode" @if(!empty($address['pincode'])) value="{{$address['pincode']}}" @else value="{{old('pincode')}}" @endif>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Special Note [optional]</label>
                                        <textarea name="note" id="note" placeholder="Enter text here...">{{$address['special_note']}}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn">Submit</button>
                                        <button class="btn"> <a href="{{url('/checkout')}}"> Back </a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--/#cart_items-->

    <!--/Footer-->
    @include('layouts.front_layout.front_footer')

    <script src="{{ url('js/front_js/jquery.js') }}"></script>
    <script src="{{ url('js/front_js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ url('js/front_js/price-range.js') }}"></script>
    <script src="{{ url('js/front_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ url('js/front_js/main.js') }}"></script>

</body>

</html>