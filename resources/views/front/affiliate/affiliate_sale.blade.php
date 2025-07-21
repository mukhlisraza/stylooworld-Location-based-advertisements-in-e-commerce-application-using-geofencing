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

                    <div class="container">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Referrering Earning</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Referrer ID</th>
                                            <th>Referrer Link</th>
                                            <th>Order ID</th>
                                            <th>Order Amount</th>
                                            <th>Commission</th>
                                            <th>Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach($referreringData as $data)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$data->referrer_id}}</td>
                                            <td>{{ $data->referrer_link}}</td>
                                            <td>{{$data->order_id}}</td>
                                            <td>{{$data->order_amount}}</td>
                                            <td>Rs. {{$data->commission}}</td>
                                            <td>{{$data->order_status}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

@endsection