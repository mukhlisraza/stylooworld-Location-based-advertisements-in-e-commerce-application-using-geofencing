<?php

use App\Product;
?>

<table class="table table-condensed">
    <thead>
        <tr class="cart_menu">
            <td class="image"><b>Image</td>
            <td><b>Title</td>
            <td style="width:13%;"><b>Size</td>
            <td><b>Color</td>
            <td style="width:13%;"><b>Quantity</td>
            <td style="width:8%;"><b>Price</td>
            <td style="width:8%;"><b>Discount</td>
            <td style="width:8%;"><b>Sub Total</td>
            <td style="width:10%;"></td>
        </tr>
    </thead>
    <tbody>
        <?php $total_price = 0; ?>
        @foreach($userCartItems as $item)
        <?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']); ?>
        <tr>
            <td class="cart_product">

                <?php $product_image_path = "images/product_images/small/" . $item['product']['main_image']; ?>
                @if(!empty($item['product']['main_image']) && file_exists($product_image_path))
                <img src="{{ asset('images/product_images/small/'.$item['product']['main_image']) }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                @else
                <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                @endif

            </td>
            <td class="cart_description">
                <h4><a class="replacetext" href="">{{$item['product']['product_name']}}</a></h4>

            </td>
            <td class="cart_price">
                <p>{{$item['size']['size']}}</p>
            </td>
            <td class="cart_price">
                <p>{{$item['color']['color']}}</p>
            </td>
            <td class="cart_quantity">
                <div class="cart_quantity_button">
                    <input class="cart_quantity_input" type="text" name="quantity" value="{{$item['quantity']}}" autocomplete="off" size="1" disabled>
                    <button class="btnItemUpdate qtyMinus" type="button" data-cartid="{{$item['id']}}"> - </button>
                    <button class="btnItemUpdate qtyPlus" type="button" data-cartid="{{$item['id']}}"> + </button>
                </div>
            </td>
            <td class="cart_total">
                <p class="cart_total_price">Rs. {{$attrPrice['product_price'] * $item['quantity']}}</p>
            </td>
            <td class="cart_total">
                <p class="cart_total_price">Rs. {{$attrPrice['discount'] * $item['quantity']}}</p>
            </td>
            <td class="cart_total">

                <p class="cart_total_price">Rs. {{$attrPrice['final_price'] * $item['quantity']}}</p>
            </td>
            <td class="cart_delete">
                <button class="btn-danger btnItemDelete" type="button" data-cartid="{{$item['id']}}"><i class="fa fa-times"></i></button>
            </td>
        </tr>
        <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']); ?>
        @endforeach

        <tr>
            <td colspan="8" class="cart_calculation">Total Price:</td>
            <td class="cart_calculation_right">Rs. {{$total_price}}</td>
        </tr>
        <tr>
            <td colspan="8" class="cart_calculation">Delivery Charges:</td>
            <td class="cart_calculation_right" style="color: green;"> FREE </td>
        </tr>
        <tr>
            <td colspan="8" class="cart_calculation">Coupon Discount:</td>
            <td class="couponAmount cart_calculation_right">
                @if(Session::has('couponAmount'))
                Rs. {{Session::get('couponAmount')}}
                @else
                Rs. 0
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="8" class="cart_calculation">TOTAL:(Rs. {{$total_price}} - <span class="couponAmount">@if(Session::has('couponAmount')) Rs. {{Session::get('couponAmount')}} @else Rs. 0 @endif</span> ) = </td>
            <td id="total_calculation" class="grand_total">Rs. {{$total_price - Session::get('couponAmount')}}</td>
        </tr>

    </tbody>
</table>