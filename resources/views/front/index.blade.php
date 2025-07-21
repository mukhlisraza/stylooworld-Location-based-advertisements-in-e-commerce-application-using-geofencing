<?php

use App\Product;

?>


@extends('layouts.front_layout.front_layout')
@section('content')

<section>
    <div class="container">
        <div class="row">

            <!-- Side Bar -->
            @include('layouts.front_layout.front_sidebar')

            <div class="col-sm-9 padding-right">

                <div class="recommended_items">
                    <!--recommended_items-->
                    <h2 class="title text-center">Featured Items<br /> <small class="text-center">({{$featuredItemsCount}} featured products)</small></h2>
                    <div id="recommended-item-carousel" @if($featuredItemsCount> 4) class="carousel slide" @endif data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($featuredItemsChunk as $key => $featuredItem)
                            <div class="item @if($key==0) active @endif">
                                @foreach($featuredItem as $item)
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper" style="height: 360px;">
                                        <div class="single-products">
                                            <div class="productinfo2 text-center">
                                                <?php $product_image_path = 'images/product_images/small/' . $item['main_image'];
                                                ?>
                                                @if(!empty($item['main_image']) && file_exists($product_image_path))
                                                <a href="{{url('/product/'.$item['id'])}}"><img src=" {{ asset('images/product_images/small/'.$item['main_image'])}}" class="img-thumbnail" alt="Cinque Terre" style="object-fit:cover"></a>
                                                @else
                                                <a href="{{url('/product/'.$item['id'])}}"> <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" style="object-fit:cover"></a>

                                                @endif

                                                <!-- Discount Function -->
                                                <?php $discounted_price = Product::getDiscountedPrice($item['id']);
                                                $discount =  ($discounted_price * 100 / $item['product_price']);
                                                $discountPercent = 100 - $discount;

                                                ?>

                                                <br />
                                                <div class="pricediscount">
                                                    @if($discounted_price>0)

                                                    <h2 class="priceVSdiscount">Rs. {{$discounted_price}}</h2>

                                                    @endif

                                                    @if($discounted_price>0)
                                                    <del class="text-danger">
                                                        <h5 class="priceVSdiscount">Rs. {{$item['product_price']}}</h5>
                                                    </del>
                                                    @else
                                                    <h2 class="priceVSdiscount">Rs. {{$item['product_price']}}</h2>
                                                    @endif
                                                    <br />
                                                    <p>@if($discounted_price>0) <span class="badge badge-danger"> Discount: {{$discountPercent}} %</span> @else <span class="badge badge-danger"> </span>@endif</p>

                                                </div>
                                                <p class="replacetext">{{$item['product_name']}}</p>

                                                <a href="{{url('/product/'.$item['id'])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <!--/recommended_items-->

                <div class="features_items">
                    <!--features_items-->
                    <h2 class="title text-center">recommended items</h2>
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
                    @foreach($newProducts as $product)
                    <div class="col-sm-4">
                        <div class="product-image-wrapper" style="height: 412px;">
                            <div class="single-products">

                                <div class="productinfo text-center">
                                    <?php $product_image_path = 'images/product_images/small/' . $product['main_image'];
                                    ?>
                                    @if(!empty($product['main_image']) && file_exists($product_image_path))
                                    <a href="{{url('/product/'.$product['id'])}}">
                                        <img src=" {{ asset('images/product_images/small/'.$product['main_image'])}}" style="object-fit:cover" class="img-thumbnail" alt="Cinque Terre">
                                    </a>
                                    @else
                                    <a href="{{url('/product/'.$product['id'])}}">
                                        <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre">
                                    </a>
                                    @endif


                                    <!-- Discount Function -->
                                    <?php $discounted_price = Product::getDiscountedPrice($product['id']);

                                    $discount =  ($discounted_price * 100 / $product['product_price']);
                                    $discountPercent = 100 - $discount;

                                    ?>
                                    <div class="pricediscount">
                                        @if($discounted_price>0)
                                        <h2 class="priceVSdiscount">Rs. {{$discounted_price}}</h2>
                                        @endif

                                        @if($discounted_price>0)
                                        <del class="text-danger">
                                            <h5 class="priceVSdiscount">Rs. {{$product['product_price']}}</h5>
                                        </del>
                                        @else
                                        <h2 class="priceVSdiscount">Rs. {{$product['product_price']}}</h2>
                                        @endif
                                    </div>
                                    <span>{{$product['vendor']['business_name']}}</span>

                                    <p class="replacetext">{{$product['product_name']}}</p>

                                </div>

                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        @if($discounted_price>0)
                                        <button id="buttonsale" class="newSale">{{$discountPercent}} % OFF</button>
                                        @endif
                                    </div>

                                    @if(Cookie::get($product['id']))
                                    <form action="{{url('add-to-reminder')}}" method="post" class="reminder_compare">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                                        <button type="submit" class="new"> <img src="{{asset('images/ico/heart-icon-filled.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                                    </form>
                                    @else
                                    <form action="{{url('add-to-reminder')}}" method="post" class="reminder_compare">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                                        <button type="submit" class="new"> <img src="{{asset('images/ico/heart-icon-unfill.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                                    </form>
                                    @endif

                                    <a href="{{url('/product/'.$product['id'])}} "><button type="submit" class="newCart"> <img src="{{asset('images/ico/cart-icon.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                                    </a>


                                </div>
                            </div>

                        </div>

                    </div>
                    @endforeach
                </div>
                <!--features_items-->

            </div>
        </div>
    </div>
</section>

@endsection