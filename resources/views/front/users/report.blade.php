@extends('layouts.front_layout.front_layout')
@section('content')

<section>
    <div class="container">
        <div id="contact-page" class="container">
            <div class="bg">
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="title text-center">Report Us! <br> <br> Response Get will Soon</h2>
                        <div class="contact-map">

                            <img src="{{asset('images/report/report1.jpg')}}" id="report-img" alt="">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="contact-form">
                            @if($errors->any())
                            <div class="alert alert-danger" style="margin-top:10px;">
                                <ul>
                                    @foreach($errors->all() as $errors)
                                    <li>
                                        {{$errors}}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if (Session::has('report_success'))
                            <div class="alert alert-success " role="alert">
                                {{Session::get('report_success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            @if (Session::has('report_error'))
                            <div class="alert alert-danger " role="alert">
                                {{Session::get('report_error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <h2 class="title text-center">Report</h2>
                            <div class="status alert alert-success" style="display: none"></div>

                            <form action="{{url('/product-report')}}" method="post">
                                @csrf
                                <div class="form-group col-md-6">
                                    <input type="text" name="order_id" id="order_id" placeholder="Order ID" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" name="email" id="email" placeholder="Email Address" class="form-control">
                                </div>

                                <div class="form-group col-md-12">
                                    <textarea name="report" id="message" required="required" class="form-control" rows="8" cols="50" placeholder="Report..."></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary pull-right">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-info">
                            <h2 class="title text-center">Conditions for Report</h2>
                            <address>
                                <ol>
                                    <li> The product must be unused, unworn, unwashed and without any flaws. Fashion products can be tried on to see if they fit and will still be considered unworn. If a product is returned to us in an inadequate condition, we reserve the right to send it back to you.</li>
                                    <li>The product must include the original tags, user manual, warranty cards, freebies and accessories.</li>
                                    <li>The product must be returned in the original and undamaged manufacturer packaging / box. If the product was delivered in a second layer of stylooworld packaging, it must be returned in the same condition with return shipping label attached. Do not put tape or stickers on the manufacturers box.</li>
                                </ol>

                            </address>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/#contact-page-->
    </div>
    </div>
</section>

@endsection