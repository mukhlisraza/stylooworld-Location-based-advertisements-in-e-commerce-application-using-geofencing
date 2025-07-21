<?php

use App\Banner;

$getBanners = Banner::getBanners();

?>
<section id="slider">
    <!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        @foreach($getBanners as $key => $banner)
                        <div class="item @if($key==0) active @endif">
                            <div class="col-sm-6">
                                <h1><span>K</span>irmaan</h1>
                                <h2>{{$banner['title']}}</h2>
                                <p>Smart Style Have Smart Decision</p>
                                <button type="button" class="btn btn-default">Get it now</button><br /><br />
                                @if($key==0)
                                <a href=""> <img src="{{ asset('images/banner_images/googleplayButton.png')}}" class="girl img-responsive " alt="" width="30%" height="20%" /></a>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <a @if(!empty($banner['link'])) href="{{url($banner['link'])}}" @else href="javascript:void(0)" @endif><img src="{{ asset('images/banner_images/'.$banner['image'])}}" class="girl img-responsive" alt="{{$banner['alt']}}" title="{{$banner['alt']}}" /></a>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
<!--/slider-->