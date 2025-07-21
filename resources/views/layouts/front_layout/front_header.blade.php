<?php

use App\Section;

$sections = Section::sections();
// echo "pre";
// print_r($sections);
// die;
?>

<!--header-->
<div class="header_top">
	<!--header_top-->
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="contactinfo">
					<ul class="nav nav-pills">
						<li id="cart-header"><a href="/affiliate"> Earn With Kirmaan </a></li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</div>
<!--/header_top-->

<div class="header-middle">
	<!--header-middle-->
	<div class="container">
		<div class="row">
			<div class="col-md-4 clearfix">
				<div class="logo pull-left">
					<a href="{{ url('/')}}"><img src="{{ asset('images/front_images/home/logo.png') }}" style="object-fit:scale-down" alt="" width="150px" height="60px" /></a>
				</div>

			</div>
			<div class="col-md-8 clearfix">
				<div class="shop-menu clearfix pull-right">
					<ul class="nav navbar-nav">
						<li>
							<a href="/cart">
								@if(totalCartItems() == null)
								<i class="fa fa-shopping-cart"></i>Cart
								@else
								<i class="fa fa-shopping-cart"></i>Cart
								<span class="badge badge-warning">
									<span class="totalCartItems"> {{ totalCartItems() }} Items
									</span>
								</span>
								@endif
							</a>
						</li>
						<li>
							<a href="{{url('/reminderlist')}}" class="btn ">
								<i class="fa fa-heart"></i>
								<span>wishlist</span>
							</a>
						</li>
						@if(Auth::check())
						<li>
							<a href="{{url('/notification')}}" class="btn ">
								<i class="fa fa-bell"></i>
								<span>({{totalNotifications()}})</span>
							</a>
						</li>
						<li><a href="{{url('/account')}}"><i class="fa fa-user"></i> Account</a></li>
						<li><a href="{{url('/logout')}}"><i class="fa fa-sign-out"></i>Logout</a></li>
						@else
						<li><a href="{{url('/login')}}"><i class="fa fa-lock"></i> Login / Register</a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/header-middle-->

<div class="header-bottom">
	<!--header-bottom-->
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="mainmenu pull-left">
					<ul class="nav navbar-nav collapse navbar-collapse">
						<li><a href="{{url('/')}}" class="{{ ( (Request::is('/'))) ? 'active' :'' }}">Home</a></li>
						@foreach($sections as $section)
						@if(count($section['categories'])>0)
						<li class=" dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$section['name']}}<i class="fa fa-angle-down"></i></a>
							<ul role="menu" class="sub-menu" class="dropdown-menu">
								@foreach($section['categories'] as $category)
								<li><a href="{{url($category['category_name'])}}">{{$category['category_name']}}</a></li>
								@foreach($category['subcategories'] as $subcategory)
								<li><a href="{{url($subcategory['category_name'])}}">&nbsp;&nbsp;&nbsp;&nbsp;&gt; {{$subcategory['category_name']}}</a></li>
								@endforeach
								@endforeach
							</ul>
						</li>
						@endif
						@endforeach
						<li><a href="{{url('/contactus')}}" class="{{ ( (Request::is('contactus'))) ? 'active' :'' }}">Contact</a></li>

					</ul>
				</div>

			</div>
			<div class="col-sm-3">
				<div class="search_box pull-right">
					<div class="search-container">
						<form action="{{route('search')}}" method="GET" class="search-form">
							<input type="text" placeholder="Search.." value="{{request()->input('query')}}" name="query" id="query" minlength="3">

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/header-bottom-->
<!--/header-->