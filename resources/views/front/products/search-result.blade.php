<?php

use App\Product;

?>
@extends('layouts.front_layout.front_layout')
@section('content')

<section>

    <div class="container">
        <div class="row">
            <section id="advertisement">
                <div class="container">
                    <img src="{{ asset('images/front_images/products/productbanner.jpg') }}" alt="" />
                </div>
            </section>

            <!-- Side Bar -->
            @include('layouts.front_layout.front_sidebar')

            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8.5 padding-right">
                            <div class="features_items">
                                <!--features_items-->
                                <h2 class="title text-center">Search Items </h2>
                                <hr>
                                <p>{{$categoryProducts->count()}} item(s) for '{{request()->input('query')}}' search results</p>
                                <hr>
                                @foreach($categoryProducts as $products)
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper" style="height: 412px;">
                                        <div class="single-products">
                                            <div class="productinfo text-center">

                                                @if(isset($products['main_image']))
                                                <?php $product_image_path = 'images/product_images/small/' . $products['main_image']; ?>
                                                @else
                                                <?php $product_image_path = ''; ?>
                                                @endif

                                                @if(!empty($products['main_image']) && file_exists($product_image_path))
                                                <a href="{{url('/product/'.$products['id'])}} ">
                                                    <img src=" {{ asset('images/product_images/small/'.$products['main_image'])}}" style="object-fit:cover" class="img-thumbnail" alt="Cinque Terre">
                                                </a>
                                                @else
                                                <a href="{{url('/product/'.$products['id'])}} ">
                                                    <img src="{{ asset('images/product_images/small/no_image.png') }}" style="object-fit:cover" class="img-thumbnail" alt="Cinque Terre">
                                                </a>
                                                @endif

                                                <!-- Discount Function -->
                                                <?php $discounted_price = Product::getDiscountedPrice($products['id']);

                                                $discount =  ($discounted_price * 100 / $products['product_price']);
                                                $discountPercent = 100 - $discount;

                                                ?>
                                                <div class="pricediscount">
                                                    @if($discounted_price>0)
                                                    <h2 class="priceVSdiscount">Rs. {{$discounted_price}}</h2>
                                                    @endif

                                                    @if($discounted_price>0)
                                                    <del class="text-danger">
                                                        <h5 class="priceVSdiscount">Rs. {{$products['product_price']}}</h5>
                                                    </del>
                                                    @else
                                                    <h2 class="priceVSdiscount">Rs. {{$products['product_price']}}</h2>
                                                    @endif

                                                </div>
                                                <span>{{$products['vendor']['business_name']}}</span>
                                                <p class="replacetext">{{$products['product_name']}}</p>


                                            </div>
                                            <div class="product-overlay">
                                                <div class="overlay-content">
                                                    @if($discounted_price>0)
                                                    <button id="buttonsale" class="newSale">{{$discountPercent}} % OFF</button>

                                                    @endif
                                                </div>
                                                @if(Cookie::get($products['id']))
                                                <form action="{{url('add-to-reminder')}}" method="post" class="reminder_compare">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$products['id']}}">
                                                    <button type="submit" class="new"> <img src="{{asset('images/ico/heart-icon-filled.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                                                </form>
                                                @else
                                                <form action="{{url('add-to-reminder')}}" method="post" class="reminder_compare">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$products['id']}}">
                                                    <button type="submit" class="new"> <img src="{{asset('images/ico/heart-icon-unfill.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                                                </form>
                                                @endif


                                                <a href="{{url('/product/'.$products['id'])}} "><button type="submit" class="newCart"> <img src="{{asset('images/ico/cart-icon.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                                                </a>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endforeach

                            </div>
                            <!--features_items-->
                            <!-- Simple Piginations -->
                            @if(isset($_GET['sort']) && !empty($_GET['sort']))
                            {{ $categoryProducts->appends(['sort' => $_GET['sort']])->links() }}
                            @else
                            {{ $categoryProducts->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

@endsection