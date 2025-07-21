<?php

namespace App\Http\Controllers\Front;

use App\Admin;
use App\Brand;
use App\Cart;
use App\Category;
use App\Compare;
use App\Coupon;
use App\DeliveryAddress;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use App\Product;
use App\ProductsAttribute;
use App\Reminderlist;
use App\User;
use App\Sms;
use App\Review;
use DateTime;
// use Facade\FlareClient\View;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Country;
use App\Order;
use App\OrdersProduct;
use App\ProductColor;
use App\Referrer;
use App\ReferrerSale;
use App\Report;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session as FacadesSession;
use Vonage\Message\Shortcode\Alert;

class ProductsController extends Controller
{
    //URL is basically slog of the listing page
    public function listing(Request $request)
    {
        Paginator::useBootstrap();
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $url = $data['url'];
            $categoryCount = Category::where(['category_name' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand', 'vendor')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                // echo "<pre>";
                // print_r($categoryDetails);

                // echo "<pre>";
                // print_r($categoryProducts);
                // die;


                //Checking for brand
                if (isset($data['brand']) && !empty($data['brand'])) {
                    $brandId = Brand::select('id')->whereIn('name', $data['brand'])->pluck('id');
                    // dd($brandId);
                    // die;

                    $categoryProducts->whereIn('products.brand_id', $brandId);
                }

                //Checking for fabrics
                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }

                //Checking for sleeve
                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }

                //Checking for sleeve
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }

                //Checking for sleeve
                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }

                //Checking for sleeve
                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }


                // If Sort option selected by users
                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort'] == 'product_latest') {
                        $categoryProducts->orderBy('id', 'Desc');
                    } else if ($data['sort'] == 'product_name_a_z') {
                        $categoryProducts->orderBy('product_name', 'Asc');
                    } else if ($data['sort'] == 'product_name_z_a') {
                        $categoryProducts->orderBy('product_name', 'Desc');
                    } else if ($data['sort'] == 'price_lowest') {
                        $categoryProducts->orderBy('product_price', 'Asc');
                    } else if ($data['sort'] == 'price_highest') {
                        $categoryProducts->orderBy('product_price', 'Desc');
                    }
                } else {
                    $categoryProducts->orderBy('id', 'Desc');
                }

                $categoryProducts = $categoryProducts->Paginate(12);


                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            // echo "<pre>";
            // print_r($url);
            // die;
            $categoryCount = Category::where(['category_name' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                $categoryProducts = $categoryProducts->Paginate(12);

                // Filter Arrays
                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];


                // Brands Filters
                $brandArray = Brand::select('name')->where('status', 1)->pluck('name');
                // dd($brandArray);
                // die;

                $page_name = "listing";
                // Newsletter Coupon
                $dt = new DateTime();
                $dt->format('Y-m-d');
                $dates = Coupon::where('expiry_date', '>', $dt)->where('status', 1)->get()->toArray();

                if ($dates != null) {
                    $coupon = Coupon::with(['category' => function ($query) {
                        $query->select('id', 'parent_id', 'category_name', 'discription')->where('status', 1);
                    }])->where(['users' => ''])->orderBy('id', 'Desc')->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->first()->toArray();


                    $couponCategory = Coupon::select('categories')->where('expiry_date', '>', $dt)->where('status', 1)->first();
                    $couponsCat = explode(',', $couponCategory);

                    $categoriesDetails = Category::select('category_name')->whereIn('id', $couponsCat)->whereNotIn('parent_id', [0, 0])->get()->toArray();
                    // echo "<pre>";
                    // print_r($coupon);
                    // die;
                    return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url', 'brandArray', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'page_name', 'coupon', 'categoriesDetails'));
                } else {
                    // $coupon = "";
                    // echo "<pre>";
                    // print_r($dates);
                    // die;
                    return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url', 'brandArray', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'page_name'));
                }
                // Newsletter Coupon End


            } else {
                abort(404);
            }
        }
    }

    //Product Detail Page
    public function detail($id)
    {

        $featuredItemsCount = Product::where('status', 1)->count();
        $productDetails = Product::with(['category', 'vendor', 'brand', 'attributes' => function ($quary) {
            $quary->where('status', 1);
        }, 'colors' => function ($quary) {
            $quary->where('status', 1);
        }, 'images'])->find($id)->toArray();
        // dd($productDetails);
        // die;

        $total_stock = ProductsAttribute::where('product_id', $id)->sum("stock");
        $relatedProduct = Product::where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->inRandomOrder()->get()->toArray();
        // dd($relatedProduct);
        // die;

        $productReview = Review::where('product_id', $id)->orderBy('id', 'Desc')->get()->toArray();
        // dd($productReview);
        // die;
        $rating = Review::where('product_id', $id)->select('rating')->sum('rating');
        // dd($rating);
        // die;
        $totalReview = Review::where('product_id', $id)->select('rating')->count();
        if ($totalReview > 0) {
            $totalRating = $rating / $totalReview;
        } else {
            $totalRating = 0;
        }

        $relatedItemsChunk = array_chunk($relatedProduct, 3);
        $relatedItemsCount = Product::where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->count();
        return view('front.products.details')->with(compact('productDetails', 'total_stock', 'relatedItemsCount', 'relatedItemsChunk', 'productReview', 'totalRating'));
    }

    public function getAttributeColor(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $productDetails = ProductColor::where(['size_id' => $data['getPrice'], 'status' => 1])->get();
            // $productDetails = json_decode(json_encode($productDetails), true);
            // $productDetails = json_decode(json_encode($productDetails), true);
            //print($productDetails);
            return $productDetails;
            // die();
            // return view('front.products.append_attribute_colors')->with(compact('productDetails'));
        }
    }

    // Getting Product Attribute Price
    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($data['product_id'], $data['size']);
            return $getDiscountedAttrPrice;
        }
    }

    public function review(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // echo "<pre>";
            // print_r($data);
            // die;

            $review = new Review;
            $review->product_id = $data['product_id'];
            $review->vendor_id = $data['vendor_id'];
            $review->user_name = $data['user_name'];
            $review->review = $data['review'];
            $review->rating = $data['rating'];
            $review->save();
        }

        $message = "Review has successfully done.";
        Session::flash('success_message', $message);
        return redirect()->back();
    }


    // Add to Cart
    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            // Check Product Stock is available or not
            $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'], 'id' => $data['size']])->first()->toArray();

            $getProductColorStock = ProductColor::where(['product_id' => $data['product_id'], 'id' => $data['color']])->first()->toArray();


            // echo $getProductStock['stock'];
            // die;
            if ($getProductStock['stock'] < $data['quantity']) {
                $message = "Required Quantity Out of the Stock";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if ($getProductColorStock['stock'] < $data['quantity']) {
                $message = "This color is out of the stock";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            // Generate Session Id if not Exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id); //generate the session_id and put in session it self

            }

            // Save Product in Cart
            // Cart::insert(['session_id' => $session_id, 'product_id' => $data['product_id'], 'size' => $data['size'], 'quantity' => $data['quantity']]);

            // check if product already exist in use cart
            if (Auth::check()) {
                //user is logged in 
                $countProduct = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => Auth::user()->id])->count();
            } else {
                //user is not logged in
                $countProduct = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => Session::get('session_id')])->count();
            }
            if ($countProduct > 0) {
                $message = "Product Already Exist In Cart";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = 0;
            }

            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->vendor_id = $data['vendor_id'];
            $cart->vendor_name = $data['vendor_name'];
            $cart->business_name = $data['vendor_businessName'];
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->color = $data['color'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            $message = "Product has been added in cart";
            session::flash('success_message', $message);
            return redirect()->back();
        }
    }


    // Cart
    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        // echo "<pre>";
        // print_r($userCartItems);
        // die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }

    // 
    public function updateCartItemQty(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            // echo "<pre>";
            // print_r($data);
            // die;    

            //Get Cart Details
            $cartDetails = Cart::find($data['cartid']);

            //Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id' => $cartDetails['product_id'], 'id' => $cartDetails['size']])->first()->toArray();
            // echo "<pre>";
            // print_r($availableStock);
            // die;

            //check stock is available or not
            if ($data['qty'] > $availableStock['stock']) {
                $userCartItems = Cart::userCartItems();

                return response()->json([
                    'status' => false,

                    'message' => 'Product Stock Not Available',
                    'view' => (string)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            //checking available size
            $availableSize = ProductsAttribute::select('stock')->where(['product_id' => $cartDetails['product_id'], 'id' => $cartDetails['size'], 'status' => 1])->count();

            if ($availableSize == 0) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Size Not Available',
                    'view' => (string)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            Cart::where('id', $data['cartid'])->update(['quantity' => $data['qty']]);
            $userCartItems = Cart::userCartItems();
            $totalCartItems  = totalCartItems();
            return response()->json([
                'status' => true,
                'totalCartItems' => $totalCartItems,
                'view' => (string)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }

    // Delete Cart Items
    public function deleteCartItem(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Cart::where('id', $data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            $totalCartItems  = totalCartItems();
            return response()->json([
                'totalCartItems' => $totalCartItems,
                'view' => (string)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }

    // Reminder List 
    public function addToReminder(Request $request)
    {
        // echo $request->product_id;
        // die;
        if ($request->hasCookie($request->product_id)) {
            $cookie = Cookie::forget($request->product_id);
            $message = "Item in wish list successfully deleted";
            session::flash('success_message', $message);
            return redirect()->back()->withCookie($cookie);
        } else {
            Cookie::queue($request->product_id, $request->product_id, 44640);
            $message = "Product has been added in reminder list";
            session::flash('success_message', $message);
            return redirect()->back();
        }

        /*
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;


            // check if product already exist in use Reminder List
            if (Auth::check()) {
                //user is logged in 
                $countProduct = Reminderlist::where(['product_id' => $data['product_id'], 'user_id' => Auth::user()->id])->count();
            }

            if ($countProduct > 0) {
                $message = "Product Already Exist In Reminder List";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = 0;
            }

            $reminder = new Reminderlist();
            $reminder->user_id = $user_id;
            $reminder->product_id = $data['product_id'];
            $reminder->save();

            $message = "Product has been added in reminder list";
            session::flash('success_message', $message);
            return redirect()->back();
        }

        */
    }

    // ReminderList Code
    public function reminderList(Request $request)
    {

        $data = array();
        foreach (Cookie::get() as $key => $value) {
            $product = Product::where('id', $value)->first();
            if (!empty($product)) {
                $data[] = array('product' => $product);
            }
        }

        // $userReminderItems = Reminderlist::userReminderItems();

        // echo "<pre>";
        // print_r($data);
        // die;
        return view('front.products.reminderlist')->with(compact('data'));
    }

    // Delete remidner Items
    public function deleteReminderItem($id)
    {

        // echo "<pre>";
        // print_r($id);
        // die;
        $cookie = Cookie::forget($id);
        $message = "Item in wish list successfully deleted";
        session::flash('success_message', $message);
        return Response::make(redirect()->back())->withCookie($cookie);



        /*
        if ($request->ajax()) {
            $data = $request->all();
            echo "<pre>";
            print_r($data);
            die;

            Reminderlist::where('id', $data['reminderid'])->delete();
            $userReminderItems = Reminderlist::userReminderItems();
            return response()->json([

                'view' => (string)View::make('front.products.reminder_items')->with(compact('userReminderItems'))
            ]);
        }
        */
    }
    /*
    // Compare products
    public function addToCompare(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // echo "<pre>";
            // print_r($data);
            // die;

            // Generate Session Id if not Exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id); //generate the session_id and put in session it self
            }

            $compare = new Compare;
            $compare->product_id = $data['product_id'];
            $compare->session_id = $session_id;
            $compare->save();

            $userCompareItems = Compare::with('product')->where('session_id', $session_id)->orderBy('id', 'Desc')->first()->toArray();

            $productReview = Review::where('product_id', $data['product_id'])->count();
            // dd($productReview);
            // die;

            $rating = Review::where('product_id', $data['product_id'])->select('rating')->sum('rating');
            // dd($rating);
            // die;
            $totalReview = Review::where('product_id', $data['product_id'])->select('rating')->count();
            if ($totalReview > 0) {
                $totalRating = $rating / $totalReview;
            } else {
                $totalRating = 0;
            }

            // echo "<pre>";
            // print_r($userCompareItems);
            // die;
            return view('front.products.compareproducts')->with(compact('userCompareItems', 'productReview', 'totalRating'));
        }
    }
    */

    // Coupon Functionality
    public function applyCoupon(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pr>";
            // print_r($data);
            // die;
            $userCartItems = Cart::userCartItems();
            // echo "<pre>";
            // print_r($userCartItems);
            // die;
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();

            if ($couponCount == 0) {
                $userCartItems = Cart::userCartItems();
                $totalCartItems = totalCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'This coupon is not valid!',
                    'totalCartItems' => $totalCartItems,
                    'view' => (string)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            } else {
                //checking for other coupon conditions

                // get coupon details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                // check if coupon is active or inactive
                if ($couponDetails->status == 0) {
                    $message = "This coupon is not active!";
                }

                //check coupon expiry date
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if ($expiry_date < $current_date) {
                    $message = "This coupon is Expired!";
                }

                // Check if coupon is single or multiple type
                if ($couponDetails->coupon_type == "Single Times") {
                    // Check in orders table if coupon is already availed by the user
                    $couponCount = Order::where(['coupon_code' => $data['code'], 'user_id' => Auth::user()->id])->count();
                    if ($couponCount >= 1) {
                        $message = "This coupon is already avail by you!";
                        Session::forget('couponAmount');
                    }
                }

                // check if coupon is from selected categories
                // get all selected categories from coupon
                $catArr = explode(',', $couponDetails->categories);

                // Get cart items
                $userCartItems = Cart::userCartItems();

                // Check if coupon belongs to logged in user
                // Get all selected users of coupon
                if (!empty($couponDetails->users)) {
                    $userArr = explode(',', $couponDetails->users);
                    // echo "<pre>";
                    // print_r($userArr);
                    // die;

                    //Get user ID's of all selected users (in cart we have save the user id but in the coupon we have save the email so we convert the email into ids)
                    foreach ($userArr as $key => $user) {
                        $getUserID = User::select('id')->where('email', $user)->first()->toArray();
                        $userID[] = $getUserID['id'];
                    }
                }


                // Get cart total amount
                $total_amount = 0;

                foreach ($userCartItems as $key => $item) {
                    // check if any item belong to coupon category
                    if (!in_array($item['product']['category_id'], $catArr)) {
                        $message = "This coupon code is not for one of the selected products!";
                    }
                    if (!empty($couponDetails->users)) {
                        if (!in_array($item['user_id'], $userID)) {
                            $message = "This coupon is not for you!";
                        }
                    }

                    $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }

                // echo $total_amount;
                // die;

                if (isset($message)) {
                    $userCartItems = Cart::userCartItems();
                    $totalCartItems = totalCartItems();

                    return response()->json([
                        'status' => false,
                        'message' => $message,
                        'totalCartItems' => $totalCartItems,
                        'view' => (string)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                } else {

                    // Check is the amount type is Fixed or Percentage
                    if ($couponDetails->amount_type == 'Fixed') {
                        $couponAmount = $couponDetails->amount;
                    } else {
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }
                    // echo $couponAmount;
                    // die;
                    $grand_total = $total_amount - $couponAmount;

                    // Add coupon code & amount in session variables
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['code']); // put in session only if coupon code is correct
                    $userCartItems = Cart::userCartItems();
                    $message = "Coupon code successfully applied. You are availing the discount!";
                    $totalCartItems = totalCartItems();
                    return response()->json([
                        'status' => true,
                        'message' => $message,
                        'totalCartItems' => $totalCartItems,
                        'couponAmount' => $couponAmount,
                        'grand_total' => $grand_total,
                        'view' => (string)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }
        }
    }

    // checkout
    public function checkout(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if (empty($data['address_id'])) {
                $message = "Please select the delivery address!";
                session::flash('error_message', $message);
                return redirect()->back();
            }
            if (empty($data['payment_gateway'])) {
                $message = "Please select the payment method!";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if ($data['payment_gateway'] == 'COD') {
                $payment_method = 'COD';
            }

            // Get Delivery Address from Address_ID
            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();
            // dd($deliveryAddress);
            // die;

            DB::beginTransaction(); // It user that if query is stuck any place then they details not insert whenever the complete query run uptile to DB::commit

            $random =  Str::random(4);
            $randomOrderCode = substr(Auth::user()->name, 0, 5) . $random;

            // dd($randomOrderCode);
            // die;
            // Insert the orders details

            // Get cart details (Items)
            $cartItemsGetVendor = Cart::where('user_id', Auth::user()->id)->get()->toArray();

            $order = new Order;
            $order->order_id = $randomOrderCode;
            $order->user_id = Auth::user()->id;
            foreach ($cartItemsGetVendor as $key => $item) {
                $order->vendor_id = $item['vendor_id'];
            }
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->mobile = $deliveryAddress['cnic'];
            $order->email = Auth::user()->email;
            $order->special_note = $deliveryAddress['special_note'];
            $order->shipping_charges = 0;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "Pending";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            // Get last inserted order id
            $order_id = DB::getPdo()->lastInsertId();

            // Get cart details (Items)
            $cartItems = Cart::where('user_id', Auth::user()->id)->get()->toArray();

            // echo "<pre>";
            // print_r($cartItems);
            // die;
            foreach ($cartItems as $key => $item) {
                # code...
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;
                $cartItem->vendor_id = $item['vendor_id'];
                // Get products details
                $getProductDetails = Product::select('product_name')->where('id', $item['product_id'])->first()->toArray();

                $cartItem->product_id = $item['product_id'];
                $cartItem->product_name = $getProductDetails['product_name'];

                $proColor = ProductColor::select('color')->where('id', $item['color'])->first();
                $proSize = ProductsAttribute::select('size')->where('id', $item['size'])->first();
                $cartItem->product_size = $proSize->size;
                $cartItem->product_color = $proColor->color;

                $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);

                $cartItem->product_price = $getDiscountedAttrPrice['final_price'];
                $cartItem->product_qty = $item['quantity'];

                $cartItem->save();

                // Update Stock Value

                $product_attribute = ProductsAttribute::where(['product_id' => $item['product_id'], 'size' => $item['size']])->first();
                if ($product_attribute) {
                    $stock = $product_attribute->stock - (int) $item['quantity'];
                    $product_attribute->update(['stock' => $stock]);
                }

                // Update Color Stock Value

                $product_color = ProductColor::where(['product_id' => $item['product_id'], 'id' => $item['color']])->first();
                $stockColor = $product_color->stock - (int) $item['quantity'];
                ProductColor::where(['product_id' => $item['product_id'], 'color' => $item['color']])
                    ->update(['stock' => $stockColor]);
                // echo "<pre>";
                // print_r($stockColor);
                // die;

                // checking referrering 

                // dd(Cookie::get('referrering_product_id'));
                // die;

                if (!empty(Cookie::get('referrering_referrer_id'))) {
                    if ($item['product_id'] == Cookie::get('referrering_product_id')) {

                        // dd(Cookie::get('referrering_product_id'));
                        // die;
                        Referrer::where('referrer_id', Cookie::get('referrering_referrer_id'))
                            ->where('product_id', Cookie::get('referrering_product_id'))
                            ->increment('referrer_count', 1);
                    }

                    $referrer_sale = new ReferrerSale;
                    $referrer_sale->referrer_id = Cookie::get('referrering_referrer_id');
                    $link = Referrer::select('shorter_link')->where('referrer_id', Cookie::get('referrering_referrer_id'))
                        ->where('product_id', Cookie::get('referrering_product_id'))->first();
                    $referrer_sale->referrer_link =  $link->shorter_link;
                    $referrer_sale->order_id = $randomOrderCode;
                    $referrer_sale->order_amount = Session::get('grand_total');

                    $comission_amount = (Session::get('grand_total') / 100) * 5;

                    $referrer_sale->commission = $comission_amount;
                    $referrer_sale->save();
                }
            }

            // Insert Order Id in Session variable for Thanks page
            Session::put('order_id', $order_id);

            DB::commit();

            if ($data['payment_gateway'] == 'COD') {

                $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();


                // Sending Emails to vendor while order placed
                // $vendorsId = OrdersProduct::select('vendor_id')->where('order_id', $order_id)->pluck('vendor_id');
                // $vendorEmails = Admin::select('email')
                //     ->whereIn('id', $vendorsId)
                //     ->whereNotNull('email')
                //     ->get();
                // if (!empty($vendorEmails)) {
                //     // Get random unique order id to print 
                $randomOrderId = Order::select('order_id')->where('id', $order_id)->get();

                //     $messageData = [
                //         'order_id' => $randomOrderId,
                //     ];
                //     foreach ($vendorEmails as $vemail) {
                //         Mail::send('emails.order_notify', $messageData, function ($message) use ($vemail) {

                //             $message->to($vemail['email'])->subject('Order Placed - Kirmaan.org');
                //         });
                //     }
                // }
                // dd($vendorEmails);
                // die;

                // Send Order SMS
                $message = "Dear Customer, your order #(" . $order_id . ") has been successfully placed with Kirmaan.org. We will intimate you once your order status is change.";
                $mobile = $orderDetails['mobile'];
                Sms::sendSms($message, $mobile);

                // Send Order Mail
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $randomOrderId,
                    'orderDetails' => $orderDetails,
                ];

                Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Order Placed - Kirmaan.org');
                });


                return redirect('/thanks');
            }
        }
        $userCartItems = Cart::userCartItems();

        if (count($userCartItems) == 0) {
            $message = "Shopping cart is empty! Please add products to checkout.";
            Session::flash("error_message", $message);
            return redirect("/cart");
        }

        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        return view('front.products.checkout')->with(compact('userCartItems', 'deliveryAddresses'));
    }


    //Thanks Page
    public function thanks()
    {
        if (Session::has('order_id')) {
            // Empty the user cart table
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        } else {
            Session::forget('couponAmount');

            return redirect('/cart');
        }
    }

    // Add-Edit Delivery Address
    public function addEditDeliveryAddress(Request $request, $id = null)
    {
        if ($id == "") {
            // Add Delivery Address;

            $title = "Add Delivery Address";
            $address = new DeliveryAddress;
            $message = "Delivery address details has been added successfully!";
        } else {
            // Edit Delivery Address
            $title = "Edit Delivery Address";
            $address = DeliveryAddress::find($id);
            // echo "<pre>";
            // print_r($address);
            // die;
            $message = "Delivery address has been updated successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $rules = [
                'name' => 'required|min:3|regex:/^[\pL\s\-]+$/u',
                'address' => 'required',
                'city' => 'required|min:3',
                'mobile' => 'required|numeric|digits:11',

                'address' => 'required',
                'country' => 'required',
                'cnic' => 'required',
                'pincode' => 'numeric|digits:5',
            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'name.regex' => 'Please enter valid name, contain only characters',

                'city.required' => 'City is required',

                'mobile.required' => 'Mobile number is required',
                'country.required' => 'Country is required',
                'mobile.numeric' => 'Valid mobile number is required',
                'mobile.digits' => 'Mobile number must be 11 digits',
                'pincode.numeric' => 'Enter only numeric',
                'pincode.digits' => 'Pincode must be 5 digits',
            ];
            $this->validate($request, $rules, $customMessage);

            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->mobile = $data['mobile'];
            $address->cnic = $data['cnic'];
            $address->country = $data['country'];
            $address->city = $data['city'];
            $address->pincode = $data['pincode'];
            $address->address = $data['address'];
            $address->special_note = $data['note'];
            $address->status = 1;
            $address->save();

            Session::flash('success_message', $message);
            return redirect('/checkout');
        }

        $countries = Country::where('status', 1)->get()->toArray();
        return view('front.products.add_edit_delivery_address')->with(compact('countries', 'title', 'address'));
    }

    //Delete Delivery Address
    public function deleteAddress($id)
    {
        DeliveryAddress::where('id', $id)->delete();
        $message = "Delivery Address Deleted Successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    // Product Report
    public function report()
    {
        return view('front.users.report');
    }

    // Product Report
    public function productReport(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'order_id' => 'required',
                'email' => 'required|email',
                'report' => 'required',
            ];

            $this->validate($request, $rules);

            $checkOrder = Order::where('id', $data['order_id'])->get()->count();

            if ($checkOrder > 0) {
                $report = new Report;
                $report->order_id = $data['order_id'];
                $report->email = $data['email'];
                $report->report = $data['report'];
                $report->save();


                // Email and SMS

                $reportDetails = Report::first()->toArray();
                // echo "<pre>";
                // print_r($reportDetails);
                // die;

                // Send Order Mail
                $email = $data['email'];
                $messageData = [
                    'email' => $email,
                    'order_id' => $data['order_id'],
                    'reportDetails' => $data['report'],
                ];

                Mail::send('emails.report', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Report Against Orders- Kirmaan.org');
                });
            } else {
                $message = "There is no such (order id) exits. Please enter valid order id";
                Session::flash('report_error', $message);
                return redirect()->back();
            }
        }


        $message = "Report has been successfully done! Please check your email for further details";
        Session::flash('report_success', $message);
        return redirect()->back();
    }



    // //Search
    public function search(Request $request)
    {
        Paginator::useBootstrap();

        $query = $request->input('query');
        // $categoryProducts = Product::with('brand')->where('product_name', 'like', "%$query%")->get();
        // echo "<pre>";
        // print_r($categoryProducts);
        // die;

        $categoryProducts = Product::with('brand', 'section', 'category')->where('product_name', 'like', "%$query%")->where('status', 1)->count();

        if ($categoryProducts > 0) {
            $categoryProducts = Product::with('brand', 'section', 'category')->where('product_name', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%")
                ->orWhere('meta_title', 'like', "%$query%")
                ->orWhere('meta_description', 'like', "%$query%")
                ->orWhere('meta_keywords', 'like', "%$query%")->where('status', 1);


            $categoryProducts = $categoryProducts->Paginate(12);
            return view('front.products.search-result')->with(compact('categoryProducts'));
        } else {
            return view("front.products.no-result");
        }
    }
}
