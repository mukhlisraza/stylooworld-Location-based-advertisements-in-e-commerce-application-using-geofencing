@extends('layouts.front_layout.front_layout')
@section('content')
<div class="container bootstrap snippets bootdey">
    <div class="row">

        <div class="profile-info col-md-12">

            <div class="panel">

                <form action="{{url('affiliate/search')}}" method="GET" class="search-form">
                    <input type="text" placeholder="Search.." class="form-control input-lg" value="{{request()->input('query')}}" name="query" id="query" minlength="3" required>
                    <button type="submit" class="affiliate_button"> Search </button>
                </form>

            </div>

            <div id="cart_items">
                <div class="table-responsive cart_info">
                    <div id="AppendReminderItems">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="cart_menu">
                                    <td class="image">Image</td>
                                    <td class="description">Name</td>
                                    <td class="total">Get Affiliate Link</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($categoryProducts as $products)
                                <tr>
                                    <td class="cart_product">

                                        <?php $product_image_path = "images/product_images/small/" . $products->main_image; ?>
                                        @if(!empty($products->main_image) && file_exists($product_image_path))
                                        <img src="{{ asset('images/product_images/small/'.$products->main_image) }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                                        @else
                                        <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                                        @endif

                                    </td>
                                    <td class="cart_description">
                                        <h4><a href="">{{$products->product_name}}</a></h4>

                                    </td>
                                    <td class="cart_total">
                                        <form action="{{url('affiliate/get-affiliate-link')}}" method="post" id="affiliate-form" name="affiliate-form">
                                            @csrf
                                            <?php
                                            $current_url = URL::to('/');
                                            ?>
                                            <input type="hidden" name="referrer_link" value="{{$current_url.'/'.'affiliate'.'/'.Auth::user()->id.'/'.$products->id}}">
                                            <input type="hidden" name="referrer_id" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="product_id" value="{{$products->id}}">
                                            <button type="submit" class="btn btn-primary">Generate Link</button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection