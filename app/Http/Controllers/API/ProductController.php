<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Category;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrdersProduct;
use App\Product;
use App\ProductsAttribute;
use App\Reminderlist;
use App\Report;
use App\Review;
use App\User;
use App\Section;
use App\Sms;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // All Features Items
    public function getFeatureItems()
    {
        $featuredItemsCount = Product::where('is_featured', 'Yes')->where('status', 1)->count();
        $featuredItems = Product::where('is_featured', 'Yes')->where('status', 1)->inRandomOrder()->get()->toArray();

        $message = "All Feature Products";
        return response()->json(['status' => true, 'message' => $message, 'Total Feature Items' => $featuredItemsCount, "Feature Item" => $featuredItems,], 200);
    }

    // All Products
    public function allNewItems()
    {
        $newProducts  = Product::with('section', 'brand', 'category', 'attributes')->orderBy('id', 'Desc')->where('status', 1)->inRandomOrder()->get()->toArray();
        return response()->json(['status' => true, 'All New Products' => $newProducts,], 200);
    }

    // Single Product Details
    public function productDetails($id)
    {
        $productDetails = Product::with(['category', 'brand', 'attributes' => function ($quary) {
            $quary->where('status', 1);
        }, 'images'])->find($id)->toArray();
        // dd($productDetails);
        // die;

        $total_stock = ProductsAttribute::where('product_id', $id)->sum("stock");
        // dd($relatedProduct);
        // die;

        $productReview = Review::where('product_id', $id)->get()->toArray();
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

        return response()->json(['status' => true, 'Product Details' => $productDetails, 'Total Stock' => $total_stock, 'Product Reviews' => $productReview, 'Total Rating' => $totalRating], 200);
    }


    // Reminder List 
    public function addToReminder(Request $request, $user_id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // echo "<pre>";
            // print_r($data);
            // die;

            // check if product already exist in use Reminder List
            $countProduct = Reminderlist::where(['product_id' => $data['product_id'], 'user_id' => $user_id])->count();

            if ($countProduct > 0) {
                $message = "Product Already Exist In Reminder List";
                return response()->json(['status' => false, 'message' => $message], 200);
            }

            $reminder = new Reminderlist();
            $reminder->user_id = $user_id;
            $reminder->product_id = $data['product_id'];
            $reminder->save();

            $message = "Product has been added in reminder list";
            return response()->json(['status' => true, 'message' => $message], 200);
        }
    }

    // Get the reminder List
    public function reminderListItems($user_id)
    {

        // check if product already exist in use Reminder List
        $countProduct = Reminderlist::where(['user_id' => $user_id])->count();

        if ($countProduct == 0) {
            $message = "No Product in reminder list";
            return response()->json(['status' => false, 'message' => $message,], 200);
        }

        $userReminderItems = Reminderlist::with(['product' => function ($quary) {
            $quary->select('id', 'product_name', 'product_code', 'main_image', 'product_price');
        }])->where('user_id', $user_id)->orderBy('id', 'Desc')->get()->toArray();

        // echo "<pre>";
        // print_r($userReminderItems);
        // die;

        return response()->json(['status' => true, 'Reminder List Items' => $userReminderItems,], 200);
    }

    // Delete Remidner 
    public function deleteReminderItems($id)
    {
        Reminderlist::where('id', $id)->delete();
        $message = "Reminder list Item has been successfully deleted!";
        return response()->json(['status' => true, 'message' => $message,], 200);
    }

    // Add to cart
    public function addToCart(Request $request, $user_id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // echo "<pre>";
            // print_r($data);
            // die;

            // Check Product Stock is available or not
            if (ProductsAttribute::where(['product_id' => $data['product_id'], 'size' => $data['size']])->exists()) {
                // your code...
                $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first()->toArray();
                // echo $getProductStock['stock'];
                // die;

                if ($getProductStock['stock'] < $data['quantity']) {
                    $message = "Required Quantity Out of the Stock";
                    return response()->json(['status' => false, 'message' => $message], 200);
                }

                // Save Product in Cart
                // Cart::insert(['session_id' => $session_id, 'product_id' => $data['product_id'], 'size' => $data['size'], 'quantity' => $data['quantity']]);

                // check if product already exist in use cart
                $countProduct = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => $user_id])->count();

                if ($countProduct > 0) {
                    $message = "Product Already Exist In Cart";

                    return response()->json(['status' => false, 'message' => $message], 200);
                }

                $cart = new Cart;
                $cart->user_id = $user_id;
                $cart->product_id = $data['product_id'];
                $cart->size = $data['size'];
                $cart->quantity = $data['quantity'];
                $cart->save();

                $message = "Product has been added in cart";
                return response()->json(['status' => true, 'message' => $message], 200);
            } else {
                $message = "Product Size Not Exits";
                return response()->json(['status' => false, 'message' => $message], 200);
            }
        }
    }

    // Get Cart Items
    public function cartItems($user_id)
    {
        $userCartItems = Cart::with(['product' => function ($quary) {
            $quary->select('id', 'product_name', 'product_code', 'main_image', 'product_price');
        }])->where('user_id', $user_id)->orderBy('id', 'Desc')->get()->toArray();
        return response()->json(['status' => true, 'Cart Items' => $userCartItems], 200);
    }

    // Delete Cart Items
    public function deleteCartItems($id)
    {
        Cart::where('id', $id)->delete();
        $message = "Cart Item has been successfully deleted!";
        return response()->json(['status' => true, 'message' => $message], 200);
    }

    // checkout
    public function checkout(Request $request, $user_id, $user_email)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required|min:3|regex:/^[\pL\s\-]+$/u',
                'address' => 'required',
                'city' => 'required|min:3|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric|digits:11',

                'address' => 'required|min:10',
                'country' => 'required',
                'pincode' => 'numeric|digits:5',

            ];

            $customMessages = [
                'name.required' => 'Name is required',
                'name.regex' => 'Please enter valid name, contain only characters',

                'city.required' => 'City is required',
                'city.regex' => 'Please enter valid city',
                'mobile.required' => 'Mobile number is required',
                'country.required' => 'Country is required',
                'mobile.numeric' => 'Valid mobile number is required',
                'mobile.digits' => 'Mobile number must be 11 digits',
                'pincode.numeric' => 'Enter only numeric',
                'pincode.digits' => 'Pincode must be 5 digits',

            ];

            $validator = Validator::make($data, $rules, $customMessages);

            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 200);
            }

            DB::beginTransaction(); // It user that if query is stuck any place then they details not insert whenever the complete query run uptile to DB::commit
            // Insert the orders details
            $order = new Order;
            $order->user_id = $user_id;
            $order->name = $data['name'];
            $order->address = $data['address'];
            $order->city = $data['city'];
            $order->country = $data['country'];
            $order->pincode = $data['pincode'];
            $order->mobile = $data['mobile'];
            $order->email = $user_email;
            $order->special_note = $data['special_note'];
            $order->shipping_charges = 0;
            $order->coupon_code = $data['coupon_code'];
            $order->coupon_amount = 0;
            $order->order_status = "New";
            $order->payment_method = "COD";
            $order->payment_gateway = "COD";
            $order->grand_total = $data['grand_total'];
            $order->save();

            // Get last inserted order id
            $order_id = DB::getPdo()->lastInsertId();

            // Get cart details (Items)
            $cartItems = Cart::where('user_id', $user_id)->get()->toArray();

            // echo "<pre>";
            // print_r($cartItems);
            // die;
            foreach ($cartItems as $key => $item) {
                # code...

                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = $user_id;

                // Get products details
                $getProductDetails = Product::select('product_code', 'product_name', 'product_color')->where('id', $item['product_id'])->first()->toArray();

                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
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
            }

            DB::commit();

            $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();

            //Send Order SMS
            // $message = "Dear Customer, your order #(" . $order_id . ") has been successfully placed with stylooworld.info. We will intimate you once your order status is change.";
            // $mobile = $orderDetails['mobile'];
            // Sms::sendSms($message, $mobile);

            // // Send Order Mail
            $email = $user_email;
            $messageData = [
                'email' => $email,
                'name' => $data['name'],
                'order_id' => $order_id,
                'orderDetails' => $orderDetails,
            ];

            Mail::send('emails.order', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Order Placed - stylooworld.info');
            });
        }

        $message = "Your Order has been successfully placed!";

        Cart::where('user_id', $user_id)->delete();

        return response()->json(['status' => true, 'message' => $message], 200);
    }

    // Report
    public function userReport(Request $request)
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

            $customMessages = [
                'email.required' => 'Email is required!',
                'email.email' => 'Valid email is required',
            ];

            $validator = Validator::make($data, $rules, $customMessages);

            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 200);
            }

            $report = new Report;
            $report->order_id = $data['order_id'];
            $report->email = $data['email'];
            $report->report = $data['report'];
            $report->save();

            // Send report Mail
            $email = $data['email'];
            $messageData = [
                'email' => $email,
                'order_id' => $data['order_id'],
                'reportDetails' => $data['report'],
            ];

            Mail::send('emails.report', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Report Against Orders- stylooworld.info');
            });
        }


        $message = "Report has been successfully done! Please ";
        return response()->json(['status' => true, 'message' => $message,], 200);
    }

    // Coupon
    public function applyCoupon(Request $request, $user_id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pr>";
            // print_r($data);
            // die;

            $userCartItems = Cart::with(['product' => function ($quary) {
                $quary->select('id', 'product_name', 'product_code', 'main_image', 'product_price');
            }])->where('user_id', $user_id)->orderBy('id', 'Desc')->get()->toArray();

            // echo "<pre>";
            // print_r($userCartItems);
            // die;

            $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();

            if ($couponCount == 0) {

                $message = "This coupon is not valid!";
                return response()->json(['status' => false, 'message' => $message], 200);
            } else {
                //checking for other coupon conditions

                // get coupon details
                $couponDetails = Coupon::where('coupon_code', $data['coupon_code'])->first();

                // check if coupon is active or inactive
                if ($couponDetails->status == 0) {
                    $message = "This coupon is not active!";
                    return response()->json(['status' => false, 'message' => $message], 200);
                }

                //check coupon expiry date
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if ($expiry_date < $current_date) {
                    $message = "This coupon is Expired!";
                    return response()->json(['status' => false, 'message' => $message], 200);
                }

                // Check if coupon is single or multiple type
                if ($couponDetails->coupon_type == "Single Times") {
                    // Check in orders table if coupon is already availed by the user
                    $couponCount = Order::where(['coupon_code' => $data['coupon_code'], 'user_id' => $user_id])->count();
                    if ($couponCount >= 1) {
                        $message = "This coupon is already avail by you!";
                        return response()->json(['status' => false, 'message' => $message], 200);
                    }
                }

                // check if coupon is from selected categories
                // get all selected categories from coupon
                $catArr = explode(',', $couponDetails->categories);

                // Get cart items

                $userCartItems = Cart::with(['product' => function ($quary) {
                    $quary->select('id', 'category_id', 'product_name', 'product_code', 'main_image', 'product_price');
                }])->where('user_id', $user_id)->orderBy('id', 'Desc')->get()->toArray();

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

                        return response()->json(['status' => false, 'message' => $message], 200);
                    }
                    if (!empty($couponDetails->users)) {
                        if (!in_array($item['user_id'], $userID)) {
                            $message = "This coupon is not for you!";
                            return response()->json(['status' => false, 'message' => $message], 200);
                        }
                    }

                    $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }

                // echo $total_amount;
                // die;

                // Check is the amount type is Fixed or Percentage
                if ($couponDetails->amount_type == 'Fixed') {
                    $couponAmount = $couponDetails->amount;
                } else {
                    $couponAmount = $total_amount * ($couponDetails->amount / 100);
                }
                // echo $couponAmount;
                // die;
                $grand_total = $total_amount - $couponAmount;


                $message = "Coupon code successfully applied. You are availing the discount!";

                return response()->json([
                    'status' => true,
                    'message' => $message,

                    'couponAmount' => $couponAmount,
                    'grand_total' => $grand_total,
                    'view' => compact('userCartItems')
                ]);
            }
        }
    }

    // Products Attributes
    public function productAttributes($product_id)
    {
        $productAttributes = ProductsAttribute::select('size')->where('product_id', $product_id)->get()->toArray();
        return response()->json(['status' => true, 'ProductAttributes' => $productAttributes], 200);
    }

    // // Get Section Categories and Sub Categories
    // public function sec_cat_subcat()
    // {
    //     $sections = Section::select('id', 'name')->get()->toArray();
    //     $categories = Category::select('id', 'category_name')->where('parent_id', 0)->get()->toArray();
    //     $subcategories = Category::select('parent_id', 'category_name')->whereNotIn('parent_id', [0, 0])->get()->toArray();

    //     return response()->json(['status' => true, 'section' => $sections, 'categories' => $categories, 'subcategories' => $subcategories], 200);
    // }

    // Man Products
    public function manproducts($keyword)
    {
        if ($keyword == "men") {
            $menCount = Product::with(['category', 'section'])->where('section_id', 1)->count();
            if ($menCount > 0) {
                $menProducts = Product::with(['category', 'section'])->where('section_id', 1)->get()->toArray();
                return response()->json(['status' => true, 'Mens_Products' => $menProducts], 200);
            } else {
                $message = "No Products Available";
                return response()->json(['status' => false, 'message' => $message], 200);
            }
        } elseif ($keyword == "women") {
            $womenCount = Product::with(['category', 'section'])->where('section_id', 2)->count();
            if ($womenCount > 0) {
                $womenProducts = Product::with(['category', 'section'])->where('section_id', 2)->get()->toArray();
                return response()->json(['status' => true, 'Women_Products' => $womenProducts], 200);
            } else {
                $message = "No Products Available";
                return response()->json(['status' => false, 'message' => $message], 200);
            }
        } elseif ($keyword == "kids") {
            $kidsCount = Product::with(['category', 'section'])->where('section_id', 3)->count();
            if ($kidsCount > 0) {
                $kidsProducts = Product::with(['category', 'section'])->where('section_id', 3)->get()->toArray();
                return response()->json(['status' => true, 'kids_Products' => $kidsProducts], 200);
            } else {
                $message = "No Products Available";
                return response()->json(['status' => false, 'message' => $message], 200);
            }
        } else {
            $message = "No section Available";
            return response()->json(['status' => false, 'message' => $message], 200);
        }
    }

    // Search API
    public function search($keyword)
    {
        $seachCount = Product::with('brand', 'section', 'category')->where('product_name', 'like', "%$keyword%")->where('status', 1)->count();
        if ($seachCount > 0) {
            $categoryProducts = Product::with('brand', 'section', 'category')->where('product_name', 'like', "%$keyword%")
                ->orWhere('description', 'like', "%$keyword%")
                ->orWhere('meta_title', 'like', "%$keyword%")
                ->orWhere('meta_description', 'like', "%$keyword%")
                ->orWhere('meta_keywords', 'like', "%$keyword%")->where('status', 1)->get()->toArray();

            return response()->json(['status' => true, 'search_result_count' => $seachCount, 'search_items' => $categoryProducts], 200);
        } else {
            $message = "No Products Available";
            return response()->json(['status' => false, 'message' => $message], 200);
        }
    }

    // Geofence notification
    public function notification($user_id)
    {
        // Newsletter Coupon
        $dt = new DateTime();
        $dt->format('Y-m-d');
        $dates = Coupon::where('expiry_date', '>', $dt)->where('status', 1)->get()->toArray();

        $reminderListItems = Reminderlist::where('user_id', $user_id)->count();
        if ($dates != null && $reminderListItems > 0) {
            $couponAmount = Coupon::select(['amount'])->where(['users' => ''])->orderBy('id', 'Desc')->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->first()->toArray();
            $couponCode = Coupon::select(['coupon_code'])->where(['users' => ''])->orderBy('id', 'Desc')->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->first()->toArray();
            $couponExpiry = Coupon::select(['expiry_date'])->where(['users' => ''])->orderBy('id', 'Desc')->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->first()->toArray();

            // Getting coupon parent category
            $couponCategory = Coupon::select('categories')->where('expiry_date', '>', $dt)->where('status', 1)->first();
            $couponsCat = explode(',', $couponCategory);

            // Getting sub category
            $categoriesDetails = Category::select('category_name')->whereIn('id', $couponsCat)->whereNotIn('parent_id', [0, 0])->get();

            // Convert the array into sting
            $categoryName = array();
            foreach ($categoriesDetails as $cat) {
                $categoryName[] = $cat['category_name'];
            }
            $categoryString = implode(',',  $categoryName);

            $amount = implode(",", $couponAmount);
            $code = implode(",", $couponCode);
            $expirydate = implode(",", $couponExpiry);
            return response()->json(['status' => true, 'title' => 'Near StylooWorld Shop?', 'notification' => 'Hi! You have (' . $reminderListItems . ') products in your reminder list. Currently ' . $amount . '% off on [' . $categoryString . ']. Apply Coupon (' . $code . ') before expiry date: [' . $expirydate . ']'], 200);
        } elseif ($reminderListItems > 0) {
            return response()->json(['status' => true, 'title' => 'Near StylooWorld Shop?', 'notification' => 'Hi! You have (' . $reminderListItems . ') products in your reminder list. People say it is the best in the neighborhood. Checkout app or visit the shop'], 200);
        } elseif ($dates != null) {
            $couponAmount = Coupon::select(['amount'])->where(['users' => ''])->orderBy('id', 'Desc')->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->first()->toArray();
            $couponCode = Coupon::select(['coupon_code'])->where(['users' => ''])->orderBy('id', 'Desc')->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->first()->toArray();
            $couponExpiry = Coupon::select(['expiry_date'])->where(['users' => ''])->orderBy('id', 'Desc')->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->first()->toArray();

            // Getting coupon parent category
            $couponCategory = Coupon::select('categories')->where('expiry_date', '>', $dt)->where('status', 1)->first();
            $couponsCat = explode(',', $couponCategory);

            // Getting sub category
            $categoriesDetails = Category::select('category_name')->whereIn('id', $couponsCat)->whereNotIn('parent_id', [0, 0])->get();

            // Convert the array into sting
            $categoryName = array();
            foreach ($categoriesDetails as $cat) {
                $categoryName[] = $cat['category_name'];
            }

            $categoryString = implode(',',  $categoryName);

            $amount = implode(",", $couponAmount);
            $code = implode(",", $couponCode);
            $expirydate = implode(",", $couponExpiry);

            return response()->json(['status' => true, 'title' => 'Near StylooWorld Shop?', 'notification' => 'Hi! You are near stylooworld shop. Currently ' . $amount . '% off on [' . $categoryString . ']. Apply Coupon (' . $code . ') before expiry date: [' . $expirydate . ']'], 200);
        } else {

            return response()->json(['status' => true, 'title' => 'Near StylooWorld Shop?', 'notification' => "While you're here, check out the stylooworld shop few meters away. People say it's the best in the neighborhood!"], 200);
        }
    }
}
