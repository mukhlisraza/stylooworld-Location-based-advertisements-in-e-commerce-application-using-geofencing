@extends('layouts.front_layout.front_layout')
@section('content')

<section id="profilesection">

    <div class="container bootstrap snippets bootdey">
        <div class="row">
            <div class="profile-nav col-md-3">
                <div class="panel">
                    <div class="user-heading round">
                        <a href="#">

                            @if(!empty($userDetails['image']))
                            <img src="{{  asset('images/user_images/'.$userDetails['image'].".jpg") }}" alt="" class="img-thumbnail" alt="Cinque Terre" width="130px">
                            @else
                            <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="130px">
                            @endif

                        </a>
                        <h1>{{$userDetails['name']}}</h1>
                        <p>{{$userDetails['email']}}</p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#"> <i class="fa fa-user"></i> Profile</a></li>

                        <li><a href="/editaccount"> <i class="fa fa-edit"></i> Edit profile</a></li>
                    </ul>
                </div>
            </div>
            <div class="profile-info col-md-9">

                <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; align-content: flex-start; flex-shrink: 0; background: rgb(248, 249, 251); width: 100%; padding: 20px 0rem; overflow: hidden; margin-bottom: 20px;">
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex: 1 1 0%; max-width: 300px; font-size: 14px; border-right: 2px solid rgb(239, 240, 245); padding-left: 20px; padding-right: 20px; overflow: hidden; height: 120px;">
                        <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; place-content: flex-start; flex-shrink: 0; color: rgb(66, 66, 66); align-items: center; vertical-align: middle;">Referrering Rewards Earn&nbsp;<div aria-haspopup="true" aria-expanded="false" style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0; height: 20px; line-height: 20px;"></div>
                        </div>
                        <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; place-content: flex-start; flex-shrink: 0; padding-top: 18px; padding-bottom: 18px; color: rgb(32, 32, 32); height: 100px; align-items: center; width: 100%;"><span style="position: relative; box-sizing: border-box; flex-direction: column; align-content: flex-start; flex-shrink: 0; margin-top: 0px; margin-bottom: 0px; width: 48px; font-size: 48px; -webkit-font-smoothing: antialiased; margin-left: -10px; color: rgb(0, 62, 82); font-family: iconfont;"><i class="fa fa-credit-card"></i> </span> &nbsp; <span numberoflines="4" style="position: relative; box-sizing: border-box; flex-direction: column; align-content: flex-start; flex: 1 1 0%; margin-top: 0px; margin-bottom: 0px; font-size: 14px; color: rgb(32, 32, 32); line-height: 16px; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 4; overflow: hidden;">&nbsp;&nbsp; <a href="{{url('referrer_earning')}}"> Rs. {{$referrer_earning}} </a></span></div>
                    </div>
                    <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex: 1 1 0%; font-size: 14px; border-right: 2px solid rgb(239, 240, 245); padding-left: 20px; padding-right: 20px; overflow: hidden; height: 120px;">
                        <div style="position: relative; box-sizing: border-box; display: flex; flex-direction: row; align-content: flex-start; flex-shrink: 0; color: rgb(66, 66, 66); align-items: center; vertical-align: middle;">User Size&nbsp;<div aria-haspopup="true" aria-expanded="false" style="position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-content: flex-start; flex-shrink: 0; height: 20px; line-height: 20px;"></div>
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
                <div id="bio-grap-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel">
                                <a href="{{url('/orders')}}">
                                    <div class="panel-body">
                                        <div class="bio-chart">
                                            <div><canvas width="100" height="100px"></canvas><input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value="{{$ordersCount}}" data-fgcolor="#e06b7d" data-bgcolor="#e8e8e8" disabled></div>
                                        </div>
                                        <div class="bio-desk">
                                            <h2 class="red">Recent Orders</h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel">
                                <a href="/reminderlist">
                                    <div class="panel-body">
                                        <div class="bio-chart">
                                            <div><canvas width="100" height="100px"> </canvas><input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value="" data-fgcolor="#4CC5CD" data-bgcolor="#e8e8e8" disabled>
                                            </div>
                                        </div>
                                        <div class="bio-desk">
                                            <h2 class="terques">wishlist list items </h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection