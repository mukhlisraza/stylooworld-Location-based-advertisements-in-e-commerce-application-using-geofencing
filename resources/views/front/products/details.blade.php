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
                <h2 class="title text-center"><small class="text-center"><a href="{{url('/')}}"> Home </a> / <a href="{{url('/'.$productDetails['category']['category_name'])}}"></a> {{$productDetails['category']['category_name']}}</small></h2>
                <div class="product-details">
                    <!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <img src="{{ asset('images/product_images/large/'.$productDetails['main_image']) }}" style="object-fit:cover" alt="" />
                            <h3>ZOOM</h3>
                        </div>
                        <div id="similar-product" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <!-- <a href=""><img src="{{ asset('images/front_images/product-details/shoe01.jpg') }}" alt="" width="85" height="84"></a> -->
                                    @foreach(array_slice($productDetails['images'], 0, 3) as $image)
                                    <a href="{{ asset('images/product_images/large/'.$image['image']) }}"><img src="{{ asset('images/product_images/small/'.$image['image']) }}" style="object-fit:cover" class="img-thumbnail" alt=""></a>
                                    @endforeach
                                </div>
                                <div class="item">
                                    <!-- <a href=""><img src="{{ asset('images/front_images/product-details/shoe01.jpg') }}" alt="" width="85" height="84"></a> -->
                                    @foreach(array_slice($productDetails['images'], 0, 3) as $image)
                                    <a href="{{ asset('images/product_images/large/'.$image['image']) }}"><img src="{{ asset('images/product_images/small/'.$image['image']) }}" style="object-fit:cover" class="img-thumbnail" alt=""></a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Controls -->
                            <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-7">
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
                        <div class="product-information">
                            <!--/product-information-->

                            <form action="{{url('add-to-cart')}}" method="post" class="form-horizontal">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$productDetails['id']}}">
                                <img src="{{ asset('images/front_images/product-details/new.jpg') }}" class="newarrival" alt="" />
                                <h2>{{$productDetails['product_name']}}</h2>


                                <span>
                                    <!-- Discount Function -->
                                    <?php $discounted_price = Product::getDiscountedPrice($productDetails['id']); ?>

                                    <span class="getAttrPrice">

                                        @if($discounted_price>0)
                                        Rs. {{$discounted_price}}
                                        <del class="text-danger">
                                            <h4>Rs. {{$productDetails['product_price']}}</h4>
                                        </del>
                                        @else
                                        Rs. {{$productDetails['product_price']}}
                                        @endif

                                    </span>


                                    <div class="control-group" id="product-size">
                                        <select name="size" id="getPrice" product-id="{{$productDetails['id']}}" required>
                                            <option value="">Select Size</option>
                                            @foreach($productDetails['attributes'] as $attribute)
                                            <option value="{{$attribute['id']}}">{{$attribute['size']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br />
                                    <br>
                                    <div class="control-group" id="product-color">
                                        <select name="color" id="getColor" product-id="{{$productDetails['id']}}" required>
                                            <option value="">Select Color</option>

                                        </select>
                                    </div>
                                    &nbsp;
                                    <input name="quantity" type="number" min="0" placeholder="Qty." required />
                                </span>
                                <p><b>Vendor Name:&nbsp; </b>
                                    <a href="{{url('shop/'.$productDetails['vendor_id'])}}">
                                        {{$productDetails['vendor']['business_name']}}
                                    </a>
                                </p>
                                <p>
                                    @if($totalRating>0)
                                    <b>Rating:&nbsp; </b> {{$totalRating}}
                                    @else
                                    <b>Rating:&nbsp; </b>No Reviews
                                    @endif
                                </p>
                                <p><b>Availability:&nbsp; </b> {{$total_stock}} in stock</p>
                                <p><b>Condition:&nbsp; </b> New</p>
                                <p><b>Brand:&nbsp; </b> {{$productDetails['brand']['name']}}</p>
                                <!-- <p><a href="{{url('/report')}}" class="{{ ( (Request::is('report'))) ? 'active' :'' }}">Report</a></p> -->
                                <input type="hidden" name="vendor_id" value="{{$productDetails['vendor']['id']}}">
                                <input type="hidden" name="vendor_businessName" value="{{$productDetails['vendor']['business_name']}}">
                                <input type="hidden" name="vendor_name" value="{{$productDetails['vendor']['name']}}">
                                <a href="#">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fa fa-shopping-cart"></i>
                                        Add to Cart
                                    </button>
                                </a>

                            </form>
                            <br />

                            @if(Cookie::get($productDetails['id']))
                            <form action="{{url('add-to-reminder')}}" method="post" class="reminder_compare">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$productDetails['id']}}">
                                <button type="submit" class="new"> <img src="{{asset('images/ico/heart-icon-filled.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                            </form>
                            @else
                            <form action="{{url('add-to-reminder')}}" method="post" class="reminder_compare">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$productDetails['id']}}">
                                <button type="submit" class="new"> <img src="{{asset('images/ico/heart-icon-unfill.png')}}" width="25px" height="25px" class="new1" alt="" /></button>
                            </form>
                            @endif




                            <!-- <form action="{{url('add-to-compare')}}" method="post" class="reminder_compare">
                                        @csrf
                                <input type="hidden" name="product_id" value="{{$productDetails['id']}}">
                                <button type="submit" name="compare" id="compare"><i class="fa fa-plus-square"></i> To Compare</button>
                            </form> -->
                        </div>
                        <!--/product-information-->
                    </div>
                </div>
                <!--/product-details-->
                @if (Session::has('success_message'))
                <div class="alert alert-success " role="alert">
                    {{Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="category-tab shop-details-tab">
                    <!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Details</a></li>

                            @if($relatedItemsCount>0) <li><a href="#tag" data-toggle="tab">Related Products</a></li> @endif
                            <li><a href="#reviews" data-toggle="tab">Reviews</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <div class="col-sm-12">

                                <p>{{$productDetails['description']}}</p>

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="techSpecRow">
                                            <th colspan="2">Product Details</th>
                                        </tr>
                                        <tr class="techSpecRow">
                                            <td class="techSpecTD1"><b>Brand: </b></td>
                                            <td class="techSpecTD2">{{$productDetails['brand']['name']}}</td>
                                        </tr>


                                        @if($productDetails['fabric'])
                                        <tr class="techSpecRow">
                                            <td class="techSpecTD1"><b>Fabric: </b></td>
                                            <td class="techSpecTD2">{{$productDetails['fabric']}}</td>
                                        </tr>
                                        @endif
                                        @if($productDetails['pattern'])
                                        <tr class="techSpecRow">
                                            <td class="techSpecTD1"><b>Pattern: </b></td>
                                            <td class="techSpecTD2">{{$productDetails['pattern']}}</td>
                                        </tr>
                                        @endif
                                        @if($productDetails['fit'])
                                        <tr class="techSpecRow">
                                            <td class="techSpecTD1"><b>Fit: </b></td>
                                            <td class="techSpecTD2">{{$productDetails['fit']}}</td>
                                        </tr>
                                        @endif
                                        @if($productDetails['sleeve'])
                                        <tr class="techSpecRow">
                                            <td class="techSpecTD1"><b>Sleeve: </b></td>
                                            <td class="techSpecTD2">{{$productDetails['sleeve']}}</td>
                                        </tr>
                                        @endif
                                        @if($productDetails['occasion'])
                                        <tr class="techSpecRow">
                                            <td class="techSpecTD1"><b>Occasion: </b></td>
                                            <td class="techSpecTD2">{{$productDetails['occasion']}}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                @if($productDetails['wash_care'])
                                <h4><b>Washcare</b></h4>
                                @endif
                                <p>{{$productDetails['wash_care']}}</p>
                                <h4><b>Disclaimer</b></h4>
                                <p>
                                    There may be a slight color variation between the image shown and original product.
                                </p>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="tag">
                            <div class="recommended_items col-md-12">
                                <!--recommended_items-->
                                <h2 class="title text-center"><small class="text-center">({{$relatedItemsCount}} featured products)</small></h2>
                                <div id="recommended-item-carousel" @if($relatedItemsCount> 4) class="carousel slide" @endif data-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($relatedItemsChunk as $key => $relatedItem)
                                        <div class="item @if($key==0) active @endif">
                                            @foreach($relatedItem as $item)
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper" style="height: 345px;">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <?php $product_image_path = 'images/product_images/small/' . $item['main_image'];
                                                            ?>
                                                            @if(!empty($item['main_image']) && file_exists($product_image_path))
                                                            <a href="{{url('/product/'.$item['id'])}}"><img src=" {{ asset('images/product_images/small/'.$item['main_image'])}}" class="img-thumbnail" alt="Cinque Terre"></a>
                                                            @else
                                                            <a href="{{url('/product/'.$item['id'])}}"> <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre"></a>
                                                            @endif

                                                            <!-- Discount Function -->
                                                            <?php $discounted_price = Product::getDiscountedPrice($item['id']); ?>
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
                                                            </div>

                                                            <p class="replacetext">{{$item['product_name']}}</p>
                                                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--/recommended_items-->
                        </div>

                        <div class="tab-pane fade" id="reviews">
                            <div class="col-sm-12">
                                @if(Auth::check())
                                <form id="main-contact-form" action="{{url('/review')}}" class="contact-form row" name="contact-form" method="post">
                                    @csrf

                                    <input type="hidden" name="product_id" value="{{$productDetails['id']}}">
                                    <input type="hidden" name="vendor_id" value="{{$productDetails['vendor']['id']}}">
                                    <input type="hidden" name="user_name" value="{{Auth::user()->name}}">
                                    <textarea name="review" id="rating-review" placeholder="Share Your Experience..."></textarea>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="star-rating">
                                                    <span class="fa fa-star-o" data-rating="1"></span>
                                                    <span class="fa fa-star-o" data-rating="2"></span>
                                                    <span class="fa fa-star-o" data-rating="3"></span>
                                                    <span class="fa fa-star-o" data-rating="4"></span>
                                                    <span class="fa fa-star-o" data-rating="5"></span>
                                                    <input type="hidden" name="rating" class="rating-value">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submite" id="review-btn" class="btn btn-default ">
                                        Submit
                                    </button>
                                </form>
                                @else
                                <h3>Login to give Review <a href="{{url('login')}}">(Login)</a></h3>
                                @endif
                                <br>
                                <hr>
                                @if($totalRating>0)
                                <h3>Reviews</h3>
                                @else
                                <h3>No Reviews</h3>
                                @endif
                                <hr>
                                <div class="container">
                                    <div class="row">
                                        @foreach($productReview as $review)
                                        <ul>

                                            <li>
                                                <div class="chip">
                                                    <img src="{{asset('images/review/img_avatar.png')}}" alt="Person" width="20" height="20">
                                                    {{$review['user_name']}}
                                                </div>
                                            </li><br><br>

                                            <li>
                                                @for ($i = 0; $i < 5; $i++) @if ($i < $review['rating']) <span class="fa fa-star" data-rating="1"></span>
                                                    @else
                                                    <span class="fa fa-star-o" data-rating="1"></span>
                                                    @endif
                                                    @endfor
                                            </li><br>

                                            <li><strong>{{$review['review']}}</strong> </li><br>
                                            <li>({{date('j F, Y ', strtotime($review['created_at']))}})</li><br>
                                        </ul>
                                        <hr class="new2">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!--/category-tab-->


                <!--/recommended_items-->

            </div>

        </div>
    </div>
</section>

@endsection