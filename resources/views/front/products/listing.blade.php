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
								<h2 class="title text-center"> {{$categoryDetails['catDetails']['category_name']}} </h2>
								<span> <a href="{{'/'}}"> Home </a> / <?php echo $categoryDetails['breadcumbs']; ?></span>
								<span class="pull-right"> {{count($categoryProducts)}} Products are available</span>

								<hr>
								<p>{{$categoryDetails['catDetails']['discription']}}</p>
								<hr>
								@if (Session::has('success_message'))
								<div class="alert alert-success " role="alert">
									{{Session::get('success_message') }}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								@endif
								@if (Session::has('error_message'))
								<div class="alert alert-danger " role="alert">
									{{Session::get('error_message') }}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								@endif
								<form class="form-horizontal col-sm-12" id="sortProducts" name="sortProducts">
									<input type="hidden" name="url" id="url" value="{{$url}}">
									<div class="control-group">
										<label class="control-label alignL">Sort By </label>
										<select name="sort" id="sort">
											<option value="">Select</option>
											<option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest" ) selected="" @endif>Latest Products</option>
											<option value="product_name_a_z" @if(isset($_GET['sort']) && $_GET['sort']=="product_name_a_z" ) selected="" @endif>Product name A - Z</option>
											<option value="product_name_z_a" @if(isset($_GET['sort']) && $_GET['sort']=="product_name_z_a" ) selected="" @endif>Product name Z - A</option>
											<option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort']=="price_lowest" ) selected="" @endif>Lowest price first</option>
											<option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort']=="price_highest" ) selected="" @endif>Highest price first</option>
										</select>
									</div>
								</form>
								<div class="filter_products">
									@include('front.products.ajax_products_listing')
								</div>
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
	@if(!empty($coupon))
	<div id="bkgOverlay" class="backgroundOverlay"></div>

	<div id="delayedPopup" class="delayedPopupWindow">
		<!-- This is the close button -->
		<a href="#" id="btnClose" title="Click here to close this deal box.">[ X ]</a>
		<!-- This is the left side of the popup for the description -->
		<div class="coupon">

			<img src="{{asset('images/promo/banner.png')}}" alt="Avatar" style="width:100%; height: 200px;">
			<div class="container-newsletter" style="background-color:white">
				<h2>
					@if($coupon['amount_type'] == 'Fixed')
					<b>Rs.{{$coupon['amount']}} OFF YOUR PURCHASE</b>
					@else
					<b>{{$coupon['amount']}} % OFF YOUR PURCHASE</b>
					@endif
				</h2>
				<p style="text-align: center;">
					Enjoy {{$coupon['amount']}} off on
					@foreach($categoriesDetails as $categoryArray)
					<strong>{{$categoryArray['category_name']}}</strong>,
					@endforeach
					category <br>
					<Strong> Hurry Up!</Strong> Book your order now to avail the greate discount opportunity. <br><br>

				</p>
			</div>
			<div class="container-newsletter">
				<br>
				<p>Use Promo Code: <span class="promo"><strong>{{$coupon['coupon_code']}}</strong></span></p>
				<p class="expire"><strong> Expiry Date: </strong> {{$coupon['expiry_date']}}</p>
			</div>
		</div>
	</div>
	@endif
</section>

@endsection