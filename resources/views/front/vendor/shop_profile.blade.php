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


            <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; align-content: flex-start; flex-shrink: 0; background: rgb(248, 249, 251); width: 100%; padding: 20px 0rem; overflow: hidden; margin-bottom: 20px;">
                <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex: 1 1 0%; max-width: 300px; font-size: 14px; border-right: 2px solid rgb(239, 240, 245); padding-left: 20px; padding-right: 20px; overflow: hidden; height: 120px;">
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; place-content: flex-start; flex-shrink: 0; color: rgb(66, 66, 66); align-items: center; vertical-align: middle;">Main Category&nbsp;<div aria-haspopup="true" aria-expanded="false" style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0; height: 20px; line-height: 20px;"></div>
                    </div>
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; place-content: flex-start; flex-shrink: 0; padding-top: 18px; padding-bottom: 18px; color: rgb(32, 32, 32); height: 100px; align-items: center; width: 100%;"><span style="position: relative; box-sizing: border-box; flex-direction: column; align-content: flex-start; flex-shrink: 0; margin-top: 0px; margin-bottom: 0px; width: 48px; font-size: 48px; -webkit-font-smoothing: antialiased; margin-left: -10px; color: rgb(0, 62, 82); font-family: iconfont;"><i class="fa fa-shopping-cart"></i> </span> &nbsp;<span numberoflines="4" style="position: relative; box-sizing: border-box; flex-direction: column; align-content: flex-start; flex: 1 1 0%; margin-top: 0px; margin-bottom: 0px; font-size: 14px; color: rgb(32, 32, 32); line-height: 16px; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 4; overflow: hidden;">Multi Category</span></div>
                </div>
                <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex: 1 1 0%; font-size: 14px; border-right: 2px solid rgb(239, 240, 245); padding-left: 20px; padding-right: 20px; overflow: hidden; height: 120px;">
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; align-content: flex-start; flex-shrink: 0; color: rgb(66, 66, 66); align-items: center; vertical-align: middle;">Seller Size&nbsp;<div aria-haspopup="true" aria-expanded="false" style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0; height: 20px; line-height: 20px;"></div>
                    </div>
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; place-content: flex-start; flex-shrink: 0; padding-top: 18px; padding-bottom: 18px; color: rgb(32, 32, 32); height: 100px; align-items: center; width: 100%;">
                        <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; align-content: flex-start; flex-shrink: 0; align-items: flex-end;">
                            <div style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; width: 20px; height: 6px; margin-left: 5px; background-color: rgb(0, 62, 82);"></div>
                            <div style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; width: 20px; height: 12px; margin-left: 5px; background-color: rgb(204, 204, 204);"></div>
                            <div style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; width: 20px; height: 18px; margin-left: 5px; background-color: rgb(204, 204, 204);"></div>
                            <div style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; width: 20px; height: 24px; margin-left: 5px; background-color: rgb(204, 204, 204);"></div>
                            <div style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; width: 20px; height: 30px; margin-left: 5px; background-color: rgb(204, 204, 204);"></div>
                        </div>
                    </div>
                </div>
                <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex: 1 1 0%; font-size: 14px; border-right: 2px solid rgb(239, 240, 245); padding-left: 20px; padding-right: 20px; overflow: hidden; height: 120px;">
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0; color: rgb(66, 66, 66);">Joined</div>
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; place-content: flex-start; flex-shrink: 0; padding-top: 18px; padding-bottom: 18px; color: rgb(32, 32, 32); height: 100px; align-items: center; width: 100%;">
                        <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; align-content: flex-start; flex-shrink: 0;">
                            <p style="margin-top: 0px; margin-bottom: 0px; display: flex; flex-direction: column; justify-content: center;"><span style="position: relative; box-sizing: border-box; flex-direction: column; align-content: flex-start; flex-shrink: 0; margin-top: 0px; margin-bottom: 0px; font-size: 28px; font-weight: normal; line-height: 30px; padding-right: 10px;">{{$join->year}}</span></p>
                            <p style="margin-top: 0px; margin-bottom: 0px; display: flex; flex-direction: column; justify-content: center;"><span style="position: relative; box-sizing: border-box; flex-direction: column; align-content: flex-start; flex-shrink: 0; margin-top: 0px; margin-bottom: 0px; line-height: 12px; font-style: normal;">{{$join->month}}</span><span style="position: relative; box-sizing: border-box; flex-direction: column; align-content: flex-start; flex-shrink: 0; margin-top: 0px; margin-bottom: 0px; line-height: 12px; font-style: normal;">{{$join->day}}</span></p>
                        </div>
                    </div>
                </div>
                <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex: 1 1 0%; font-size: 14px; border-right: none; padding-left: 20px; padding-right: 20px; overflow: hidden; height: 120px;">
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0; color: rgb(66, 66, 66); margin-bottom: 16px;">Chat</div>
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0; margin-bottom: 8px;">
                        <div style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; font-size: 13px; line-height: 16px; width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Chat response rate</div>
                        <div title="No Data" style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; font-size: 12px; line-height: 16px; margin-top: 6px; color: rgb(76, 175, 80); width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">No Data</div>
                    </div>
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0;">
                        <div style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; font-size: 13px; line-height: 16px; width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Last active</div>
                        <div title="Active in: 1 day ago" style="position: relative; box-sizing: border-box; display: inline-block; flex-direction: column; align-content: flex-start; flex-shrink: 0; font-size: 12px; line-height: 16px; margin-top: 6px; color: rgb(76, 175, 80); width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">No Data</div>
                    </div>
                </div>
            </div>
            <div class="rating-area">
                <ul class="ratings">
                    <li class="rate-this">Overall shop rating:</li>
                    <li>
                        @if($totalRating >=5) <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        @elseif($totalRating >=4) <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star "></i>
                        @elseif($totalRating >=3) <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star"></i>
                        @elseif($totalRating >=2) <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star"></i>
                        @else
                        <i class="fa fa-star color"></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        @endif

                    </li>
                    <li class="color">( {{round($totalRating,1)}} Ratings )</li>
                </ul>

            </div>
            <!--/rating-area-->
            <div class="response-area">
                <h4>{{$reviewCounts}} Votes</h4>
                <ul class="media-list">
                    @foreach($productReview as $review)
                    <li class="media">

                        <a class="pull-left" href="#">
                            <img class="media-object" src="{{asset('images/review/img_avatar.png')}}" alt="">
                        </a>
                        <div class="media-body">
                            <ul class="sinlge-post-meta">
                                <li><i class="fa fa-user"></i>{{$review['user_name']}}</li>
                                <li><i class="fa fa-clock-o"></i> {{date('g:i a', strtotime($review['created_at']))}}</li>
                                <li><i class="fa fa-calendar"></i> {{date('j F, Y', strtotime($review['created_at']))}}</li>
                            </ul>
                            <p style="font-size: 15px;">{{$review['review']}}.</p>


                            @for ($i = 0; $i < 5; $i++) @if ($i < $review['rating']) <span class="fa fa-star" data-rating="1"></span>
                                @else
                                <span class="fa fa-star-o" data-rating="1"></span>
                                @endif
                                @endfor
                                <br>
                                <a class="btn btn-primary" href="javacript:void(0);"><i class="fa fa-certificate"></i>&nbsp; Verified</a>
                        </div>
                    </li>

                    @endforeach
                </ul>
            </div>
            <!--/Response-area-->
        </div>
    </div>
</div>
<br>
@endsection