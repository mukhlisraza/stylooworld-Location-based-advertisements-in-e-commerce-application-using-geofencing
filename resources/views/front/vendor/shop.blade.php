<?php

use App\Product;

?>
@extends('layouts.front_layout.front_layout')
@section('content')
<br>
<div class="container bootstrap snippets bootdey">
    <div class="row">

        <div class="profile-nav col-md-3" id="vendor_profile">
            <br>
            <div class="panel">
                <div class="user-heading round">
                    <a href="#">
                        <?php $product_image_path = 'images/admin_images/admin_photos/vendor_photos/' . $vendorDetails->image;
                        ?>
                        @if(!empty($product_image_path) && file_exists($product_image_path))
                        <img src="{{url('images/admin_images/admin_photos/vendor_photos/'.$vendorDetails->image)}}" alt="">
                        @else
                        <img src="{{url('images/admin_images/admin_photos/avatar.png')}}" alt="">
                        @endif
                    </a>
                    <h1>{{$vendorDetails->business_name}}</h1>
                    <p>Shop Name</p>
                </div>

                <ul class="nav nav-pills nav-stacked">
                    @if(Session::get('page')=="shop")
                    <?php $active = "active"; ?>
                    @else
                    <?php $active = ""; ?>
                    @endif
                    <li class="{{$active}}"><a href="{{url('shop/'.$vendorDetails->id)}}"> <i class="fa fa-calendar"></i> Products <span class="label label-warning pull-right r-activity">{{$productsCount}}</span></a></li>
                    @if(Session::get('page')=="vendor_profile")
                    <?php $active = "active"; ?>
                    @else
                    <?php $active = ""; ?>
                    @endif
                    <li class="{{$active}}"><a href="{{url('shop/profile/'.$vendorDetails->id)}}"> <i class="fa fa-user"></i> Profile</a></li>

                </ul>
            </div>
        </div>
        <div class="profile-info col-md-9">
            <div class="panel">
                <div class="bio-graph-heading">
                    Madina Collection Shop.
                </div>

            </div>
            <div class="panel" id="vendor_profile">
                <footer class="panel-footer">

                    <ul class="nav nav-pills bg-warning">

                        <li>
                            <a href="javascript:void(0);"> All Products &nbsp;
                                <span class="label label-warning r-activity">{{$productsCount}}</span>
                            </a>
                        </li>

                    </ul>
                </footer>
            </div>
            <!-- Discount Function -->


            @foreach($newProducts as $product)
            <div class="col-md-4">
                <div class="card-sl">
                    <div class="card-image">
                        <?php $product_image_path = 'images/product_images/small/' . $product['main_image'];
                        ?>
                        @if(!empty($product['main_image']) && file_exists($product_image_path))
                        <img src=" {{ asset('images/product_images/small/'.$product['main_image'])}}" style="object-fit:scale-down" alt="Cinque Terre">
                        @else
                        <img src="{{ asset('images/product_images/small/no_image.png') }}" style="object-fit:scale-down" alt="Cinque Terre">
                        @endif
                    </div>
                    @if(Cookie::get($product['id']))

                    <form action="{{url('add-to-reminder')}}" method="post" id="form-id" class="reminder_compare">
                        @csrf

                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                        <button type="submit" class="card-action"> <i class="fa fa-heart"></i></button>
                    </form>
                    @else
                    <form action="{{url('add-to-reminder')}}" method="post" id="form-id" class="reminder_compare">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                        <button type="submit" class="card-action"> <i class="fa fa-heart-o" aria-hidden="true"></i></button>
                    </form>
                    @endif
                    <div class="card-heading">
                        {{$vendorDetails->business_name}}
                    </div>
                    <div class="card-text" id="vendorProfile_productText">
                        <p class="replacetext"> {{$product['product_name']}}</p>
                    </div>
                    <?php $discounted_price = Product::getDiscountedPrice($product['id']);

                    $discount =  ($discounted_price * 100 / $product['product_price']);
                    $discountPercent = 100 - $discount; ?>
                    <div class="card-text">
                        @if($discounted_price>0)
                        <h4 class="priceVSdiscount">Rs. {{$discounted_price}}</h4>
                        @endif

                        @if($discounted_price>0)
                        <del class="text-danger">
                            <h5 class="priceVSdiscount">Rs. {{$product['product_price']}}</h5>
                        </del>
                        @else
                        <h4 class="priceVSdiscount">Rs. {{$product['product_price']}}</h4>
                        @endif
                    </div>
                    <a href="{{url('/product/'.$product['id'])}}" class="card-button"> Purchase</a>
                </div>
                <div class="product-overlay">

                    @if($discounted_price>0)
                    <button id="buttonsale" class="newSale">{{$discountPercent}} % OFF</button>
                    @endif
                </div>
                <br>
            </div>
            @endforeach
            <!-- Simple Piginations -->
            {{ $newProducts->links() }}
        </div>



    </div>
</div>
<br>
@endsection