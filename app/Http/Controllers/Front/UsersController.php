<?php

namespace App\Http\Controllers\Front;

use App\Admin;
use App\Cart;

use App\ContactUs;
use App\Order;
use App\Country;
use App\Category;
use App\Coupon;
use DateTime;
use App\Http\Controllers\Controller;
use App\Notifications\MailNotification;
use App\Product;
use App\ProductsAttribute;
use App\Referrer;
use App\ReferrerSale;
use App\Reminderlist;
use App\Review;
use App\ShopInformation;
use App\ShopTiming;
use App\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Facade\FlareClient\Time\Time;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Session;
use Image;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

// use App\Sms;

class UsersController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login');
    }

    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'phone' => 'required|numeric|digits:11',
                'password' => 'required',
            ];
            $customMessage = [
                'phone.required' => 'Phone number is required',
                'phone.digits' => 'Enter 11 digits only',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMessage);


            if (Auth::attempt(['mobile' => $data['phone'], 'password' => $data['password']]) || Auth::guard('admin')->attempt(['mobile' => $data['phone'], 'password' => $data['password'], 'status' => 1, 'type' => 'vendor'])) {

                // check email is activated or not

                $userCount = User::where('mobile', $data['phone'])->count();
                $vendorCount = Admin::where('mobile', $data['phone'])->count();
                // echo "<pre>";
                // print_r($vendorCount);
                // die;
                if ($userCount > 0) {
                    $userStatus = User::where('mobile', $data['phone'])->first();
                    if ($userStatus->status == 0) {
                        Auth::logout();
                        $message = "Your account is not activated yet! Please confirm your email to activate!";
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    //update user cart with user id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                    }

                    return redirect('/');
                }

                if ($vendorCount > 0) {
                    if (Auth::guard('admin')->user()->account_status == 0) {
                        return view('admin.admin_account_resetPassword');
                    } else {
                        return redirect('admin/dashboard');
                    }
                }
            } else {
                $message = "Invalid Username or Password";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }



    public function userLoginRegister()
    {
        return view('front.users.registration');
    }

    public function registerUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;


            $rules = [
                'name' => 'required|min:3|regex:/^[\pL\s\-]+$/u',
                'phone' => 'required|numeric|digits:11',
                'password' => 'required',

            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'name.regex' => 'Name should be characters',
                'phone.min' => 'Name should be more than 3 character',

                'phone.required' => 'Phone is required',
                'phone.email' => 'Valid phone number is required',
                'password.required' => 'Password is required',

            ];
            $this->validate($request, $rules, $customMessage);



            //checking if user already register
            $userCount = User::where('mobile', $data['phone'])->count();
            $vendorCount = Admin::where('mobile', $data['phone'])->count();
            if ($userCount > 0 || $vendorCount > 0) {
                $message = "Account already register, try different!";
                session::flash('error_message', $message);
                return redirect()->back();
            } else {
                //Register new user
                $user = new User;
                $user->name = $data['name'];

                $user->mobile = $data['phone'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->type = "user";
                $user->save();

                // // Send Confirmation Message to the User
                // $email = $data['email'];
                // $messageData = [
                //     'mobile' => $data['phone'],
                //     'name' => $data['name'],
                //     'code' => base64_encode($data['email']),
                // ];
                // Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
                //     $message->to($email)->subject("Confirm Your stylooworld account");
                // });

                // // Redirect Back 
                // $message = "Please confirm your email to activate your account!";
                // Session::flash('success_message', $message);
                // return redirect('/login');

                // Redirect Back 
                $message = "Account successfully register!";
                Session::flash('success_message', $message);
                return redirect('/login');
                /*
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    // echo "<pre>";
                    // print_r(Auth::user());
                    // die;

                    //update user cart with user id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                    }

                    // Notification::send($user, new MailNotification);

                    //Send SMS
                    // $message = "Dear Customer, you have been successfully registered with stylooworld.info. Login to your account to book orders and avail available offers.";
                    // $mobile = $data['mobile'];
                    // Sms::sendSms($message, $mobile);

                    // Email Send
                    $email = $data['email'];
                    $messageData = ['name' => $data['name'], 'mobile' => $data['mobile'], 'email' => $data['email']];
                    Mail::send('emails.register', $messageData, function ($message) use ($email) {
                        $message->to($email)->subject("Welcome to stylooworld.info");
                    });

                    return redirect('/');
                }

                */
            }
        }
    }

    // // Confirm Account
    /*
    public function confirmAccount($email)
    {
        // Decode User Email
        $email = base64_decode($email);

        // Check User Email is Exists or not
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            // user email already activated or not
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                $message = "Your email account is already activated. please login.";
                Session::flash('error_message', $message);
                return redirect('user-login');
            } else {
                // Activate user account to status 1 to activate account
                User::where('email', $email)->update(['status' => 1]);

                // Notification::send($user, new MailNotification);

                //Send SMS
                $message = "Dear Customer, you have been successfully registered with stylooworld.info. Login to your account to book orders and avail available offers.";
                $mobile = $userDetails['mobile'];
                Sms::sendSms($message, $mobile);

                // Email Send
                $messageData = ['name' => $userDetails['name'], 'mobile' => $userDetails['mobile'], 'email' => $email];
                Mail::send('emails.register', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject("Welcome to stylooworld.info");
                });

                // Redirect to login/Register page with success message
                $message = "Your email account is activated. You can login now!";
                Session::flash('success_message', $message);
                return redirect("user-login");
            }
        } else {
            abort(404);
        }
    }
*/
    // Forgot Password
    public function forPassword()
    {
        return view('front.users.forgot-password');
    }
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;


            $rules = [
                'email' => 'required|email',
            ];
            $customMessage = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
            ];
            $this->validate($request, $rules, $customMessage);


            $emailCount = User::where('email', $data['email'])->count();
            if ($emailCount == 0) {
                $message = "Email does not exists!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            // Generate Random Password
            $random_password =  Str::random(8);


            // Encode/Secure Password
            $new_password = bcrypt($random_password);

            //Update Password
            User::where('email', $data['email'])->update(['password' => $new_password]);

            // Get Forgot Password Email
            $userName = User::select('name')->where('email', $data['email'])->first();

            // Send Forgot Password Email
            $email = $data['email'];
            $name = $userName->name;
            $messageData = [
                'email' => $email,
                'name' => $name,
                'password' => $random_password,
            ];
            Mail::send('emails.forgot-password', $messageData, function ($message) use ($email) {
                $message->to($email)->subject("New password - Kirmaan.org");
            });

            // Redirect to login/register page with success message
            $message = "Please check your email for new Password!";
            Session::flash('success_message', $message);
            return redirect('/login');
        }
        return view('front.users.forgot-password');
    }

    // checking email
    public function checkEmail(Request $request)
    {
        //checking if email already register or not
        $data = $request->all();
        $emailCount = User::where('email', $data['email'])->count();
        if ($emailCount > 0) {
            return "false";
        } else {
            return "true";
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect("/");
    }

    // Account 
    public function account()
    {
        $ordersCount = Order::where('user_id', Auth::user()->id)->count();
        $reminderListDetails = Reminderlist::where('user_id', Auth::user()->id)->count();
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();

        $referreringRewards = Referrer::select('referrer_count')
            ->where('referrer_id', Auth::user()->id)->get()->pluck('referrer_count')->toArray();

        $rewardCount = array_sum($referreringRewards);

        $referrer_earning = ReferrerSale::select('commission')
            ->where('referrer_id', Auth::user()->id)
            ->pluck('commission')->toArray();

        $referrer_earning = array_sum($referrer_earning);
        // dd($referrer_earning);
        // die;

        $join = User::selectRaw('year(created_at) year, monthname(created_at) month, count(*) day')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->where('id', Auth::user()->id)
            ->first();

        return view('front.users.account')->with(compact('userDetails', 'ordersCount', 'reminderListDetails', 'join', 'rewardCount', 'referrer_earning'));
    }

    // Edit Account 
    public function editAccount(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();
        // $userDetails = json_decode(json_encode($userDetails), true);
        // dd($userDetails);
        // die;

        $countries = Country::where('status', 1)->get()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric',
            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'name.regex' => 'Please enter valid name',
                'mobile.required' => 'Mobile Number is required',
                'mobile.numeric' => 'Valid mobile Number is required',
            ];
            $this->validate($request, $rules, $customMessage);

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->country = $data['country'];
            $user->city = $data['city'];
            $user->pincode = $data['pincode'];
            $user->address = $data['address'];
            $user->save();
            $message = "Your account details has been updated successfully!";
            Session::flash('success_message', $message);

            return redirect('/account');
        }
        return view('front.users.edit-account')->with(compact('userDetails', 'countries'));
    }

    // Update Image
    public function updateUserImage(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $rules = [
                'user_image' => 'image',
            ];
            $customMessage = [
                'user_image.image' => 'Enter Valid Image',
            ];
            $this->validate($request, $rules, $customMessage);

            //Upload Image
            if ($request->hasFile('user_image')) {
                $image_tmp = $request->file('user_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/user_images/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else {
                    $imageName = "";
                }
            }
            //Update Admin Details
            User::where('id', Auth::user()->id)->update(['image' => $imageName]);

            return redirect()->back();
        }
        return view('front.user.edit-account');
    }

    //checking user current password
    public function chkUserPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $user_id = Auth::user()->id;
            $chkPassword = User::select('password')->where('id', $user_id)->first();
            if (Hash::check($data['current_pwd'], $chkPassword->password)) {
                return "true";
            } else {
                return "false";
            }
        }
    }

    public function updateUserPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $user_id = Auth::user()->id;
            $chkPassword = User::select('password')->where('id', $user_id)->first();
            if (Hash::check($data['current_pwd'], $chkPassword->password)) {
                // updated current password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id', $user_id)->update(['password' => $new_pwd]);
                $message = "Password updated successfully!";
                Session::flash('success_message', $message);
                return redirect()->back();
            } else {
                $message = "Current password is incorrect!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }

    //Contact us
    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            // Laravel validations
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email',
                'subject' => 'required|regex:/^[\pL\s\-]+$/u',
                'message' => 'required',
            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
                'subject.required' => 'Subject is required',
                'subject.regex' => 'Subject must include only characters',
                'name.regex' => 'Name must include only characters',
                'message.required' => 'Product code is required',


            ];
            $this->validate($request, $rules, $customMessage);


            //contact data save
            $contact = new ContactUs;
            $contact->name = $data['name'];
            $contact->subject = $data['subject'];
            $contact->email = $data['email'];
            $contact->message = $data['message'];
            $contact->status = 'Unseen';
            $contact->save();
        }

        $message = "Your message is successfully delivered!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    // Contact Us Page
    public function contactus()
    {
        return view('front.users.contact-us');
    }

    // Notification

    public function notification()
    {

        // Newsletter Coupon
        $dt = new DateTime();
        $dt->format('Y-m-d');
        $dates = Coupon::where('expiry_date', '>', $dt)->where('status', 1)->get()->toArray();
        $couponAvailable = Coupon::where('expiry_date', '>', $dt)->where('status', 1)->get()->count();

        // echo "<pre>";
        // print_r($couponAvailable);
        // die;

        if ($dates != null) {
            $coupon = Coupon::with(['category' => function ($query) {
                $query->select('id', 'parent_id', 'category_name', 'discription', 'category_url')->where('status', 1);
            }])->where(['users' => ''])->orderBy('id', 'Desc')->where('status', 1)->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->get()->toArray();

            $couponCategory = Coupon::select('categories')->where('expiry_date', '>', $dt)->where('status', 1)->get();
            $couponsCat = explode(',', $couponCategory);

            $categoriesDetails = Category::select('category_name')->whereIn('id', $couponsCat)->whereNotIn('parent_id', [0, 0])->get()->toArray();

            // echo "<pre>";
            // print_r($coupon);
            // die;

            return view('front.notification')->with(compact('coupon', 'categoriesDetails', 'couponAvailable'));
        }
        return view('front.notification');
    }

    //  Affiliate
    public function affiliate()
    {
        return view('front.affiliate.search');
    }

    public function search(Request $request)
    {

        $query = $request->input('query');
        // $categoryProducts = Product::with('brand')->where('product_name', 'like', "%$query%")->get();
        // echo "<pre>";
        // print_r($query);
        // die;

        Paginator::useBootstrap();

        $categoryProducts = Product::with('brand', 'section', 'category')->where('product_name', 'like', "%$query%")->where('status', 1)->count();

        if ($categoryProducts > 0) {
            $categoryProducts = Product::with('brand', 'section', 'category')->where('product_name', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%")
                ->orWhere('meta_title', 'like', "%$query%")
                ->orWhere('meta_description', 'like', "%$query%")
                ->orWhere('meta_keywords', 'like', "%$query%")->where('status', 1);


            $categoryProducts = $categoryProducts->Paginate(12);

            // echo "<pre>";
            // print_r($categoryProducts);
            // die;

            return view('front.affiliate.search-result')->with(compact('categoryProducts'));
        } else {
            return view("front.affiliate.nosearchresult");
        }
    }

    public function getAffiliateLink(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $link_exist = Referrer::where('referrer_link', $data['referrer_link'])->count();

            if ($link_exist > 0) {
                Referrer::where('referrer_link', $data['referrer_link'])->update(['referrer_link' => $data['referrer_link']]);


                $link = Referrer::latest('id')->first();
                return view('front.affiliate.generate_link')->with(compact('link'));
            } else {
                $referrer = new Referrer();
                $referrer->referrer_id = $data['referrer_id'];
                $referrer->product_id = $data['product_id'];

                $current_url = URL::to('/');
                $referrer->shorter_link = $current_url . '/' . 'shorter' . '/' . time();

                $referrer->referrer_link = $data['referrer_link'];
                $referrer->save();

                $message = "Affiliate code successfully generated!";
                Session::flash('success_message', $message);

                $link = Referrer::latest('id')->first();

                return view('front.affiliate.generate_link')->with(compact('link'));
            }
        }
    }

    public function referrerRedirect($url)
    {
        $current_url = URL::to('/');
        $link = $current_url . '/' . 'shorter' . '/' . $url;
        $detail = Referrer::where('shorter_link', $link)->first();

        // dd($detail);
        // die;

        $featuredItemsCount = Product::where('status', 1)->count();
        $productDetails = Product::with(['category', 'vendor', 'brand', 'attributes' => function ($quary) {
            $quary->where('status', 1);
        }, 'colors' => function ($quary) {
            $quary->where('status', 1);
        }, 'images'])->find($detail->product_id)->toArray();


        $total_stock = ProductsAttribute::where('product_id', $detail->product_id)->sum("stock");
        $relatedProduct = Product::where('category_id', $productDetails['category']['id'])->where('id', '!=', $detail->product_id)->inRandomOrder()->get()->toArray();
        // dd($relatedProduct);
        // die;

        $productReview = Review::where('product_id', $detail->product_id)->orderBy('id', 'Desc')->get()->toArray();
        // dd($productReview);
        // die;
        $rating = Review::where('product_id', $detail->product_id)->select('rating')->sum('rating');
        // dd($rating);
        // die;
        $totalReview = Review::where('product_id', $detail->product_id)->select('rating')->count();
        if ($totalReview > 0) {
            $totalRating = $rating / $totalReview;
        } else {
            $totalRating = 0;
        }

        $relatedItemsChunk = array_chunk($relatedProduct, 3);
        $relatedItemsCount = Product::where('category_id', $productDetails['category']['id'])->where('id', '!=', $detail->product_id)->count();

        // Set Cookies


        Cookie::queue("referrering_referrer_id", $detail->referrer_id, 1000);
        Cookie::queue("referrering_product_id", $detail->product_id, 1000);

        return view('front.products.details')->with(compact('productDetails', 'total_stock', 'relatedItemsCount', 'relatedItemsChunk', 'productReview', 'totalRating'));
    }

    public function referrer_Earning()
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();

        $referreringData = DB::table('referrer_sales')
            ->join('orders', 'referrer_sales.order_id', '=', 'orders.order_id')
            ->get();

        return view('front.affiliate.affiliate_sale')->with(compact('userDetails', 'referreringData'));
    }
}
