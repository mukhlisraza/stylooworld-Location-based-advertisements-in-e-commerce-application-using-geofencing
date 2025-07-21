<table class="table table-condensed">
    <thead>
        <tr class="cart_menu">
            <td class="image">Item</td>
            <td class="description"></td>
            <td class="price">Price</td>
            <td class="total">Add to Cart</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @if (Session::has('error_message'))
        <div class="alert alert-danger " role="alert">
            {{Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (Session::has('success_message'))
        <div class="alert alert-success " role="alert">
            {{Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @foreach($data as $reminderItems)
        <tr>
            <td class="cart_product">

                <?php $product_image_path = "images/product_images/small/" . $reminderItems['product']['main_image']; ?>
                @if(!empty($reminderItems['product']['main_image']) && file_exists($product_image_path))
                <img src="{{ asset('images/product_images/small/'.$reminderItems['product']['main_image']) }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                @else
                <img src="{{ asset('images/product_images/small/no_image.png') }}" class="img-thumbnail" alt="Cinque Terre" width="80px">
                @endif

            </td>
            <td class="cart_description">
                <h4><a class="replacetext" href="">{{$reminderItems['product']["product_name"]}}</a></h4>
                <p>Product ID: {{$reminderItems['product']['id']}}</p>
            </td>
            <td class="cart_price">
                <p>Rs. {{$reminderItems['product']['product_price']}}</p>
            </td>


            <td class="cart_total">
                <a href="{{url('/product/'.$reminderItems['product']['id'])}}"><button class="btn btn-primary">Add to Cart</button></a>
            </td>
            <td class="cart_delete">
                <a href="{{url('reminderlist/'.$reminderItems['product']['id'])}}"> <button class="btn-danger btnDelete" type="button"><i class="fa fa-times"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>