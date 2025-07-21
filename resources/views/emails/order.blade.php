<!DOCTYPE html>
<html lang="en">

<body>
    <table style="width:700px">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><img src="{{asset('images/front_images/email/logo_email.png')}}" alt=""></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Hello: {{$name}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Thank you for shopping with us. Your order details are as below:- </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Order no: ({{$order_id}}) </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table style="width: 95%" border="1px" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                    <tr bgcolor="#cccccc">
                        <td>Product Name</td>
                        <td>Code</td>
                        <td>Size</td>
                        <td>Color</td>
                        <td>Quantity</td>
                        <td>Price</td>
                    </tr>
                    @foreach($orderDetails['orders_products'] as $order)
                    <tr>
                        <td>{{$order['product_name']}}</td>
                        <td>{{$order['product_code']}}</td>
                        <td>{{$order['product_size']}}</td>
                        <td>{{$order['product_color']}}</td>
                        <td>{{$order['product_qty']}}</td>
                        <td style="width: 15%;">PKR. {{$order['product_price']}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" align="right"><strong>Delivery Charges:</strong> </td>
                        <td>PKR. {{$orderDetails['shipping_charges']}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right"><strong>Coupon Discount:</strong></td>
                        <td>PKR.
                            @if($orderDetails['coupon_amount']>0)
                            {{$orderDetails['coupon_amount']}}
                            @else
                            0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right"><strong>Grand Total:</strong></td>
                        <td>PKR. {{$orderDetails['grand_total']}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td><strong>Delivery Address :-</strong></td>
                    </tr>
                    <tr>
                        <td>{{$orderDetails['name']}}</td>
                    </tr>
                    <tr>
                        <td>{{$orderDetails['address']}}</td>
                    </tr>
                    <tr>
                        <td>{{$orderDetails['city']}}</td>
                    </tr>
                    <tr>
                        <td>{{$orderDetails['country']}}</td>
                    </tr>
                    <tr>
                        <td>{{$orderDetails['pincode']}}</td>
                    </tr>
                    <tr>
                        <td>{{$orderDetails['mobile']}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>For any enquiries, you can contact us at <a href="mailto:info@stylooworld.info">info@stylooworld.info</a></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Regards, <br>kirmaan.org</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>