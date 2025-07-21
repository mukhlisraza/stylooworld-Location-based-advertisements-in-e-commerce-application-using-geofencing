<?php

namespace App\Http\Controllers\API;

use App\ContactUs;
use App\Country;
use App\Category;
use App\Coupon;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Order;
use App\Reminderlist;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    // Register Users
    public function registerUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|max:11|min:11',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:30',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            ];

            $customMessages = [
                'name.required' => 'Name is required',
                'name.regex' => 'Name must be alphabet letters',
                'mobile.required' => 'Mobile number is required',
                'mobile.max' => 'Mobile number must be 11 character',
                'mobile.min' => 'Mobile number must be 11 character',
                'email.required' => 'Email is required!',
                'email.email' => 'Valid email is required',
                'email.unique' => 'This email is already taken',
                'password.required' => 'Password is required',
                'password.string' => 'Password must be string',
                'password.regex' => 'Password must contain letters,uppercase and lowercase letters, atleast one digits, and special characters',
            ];

            $validator = Validator::make($data, $rules, $customMessages);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' =>  implode(',', $validator->errors()->all())], 200);
            }

            $user = new User;
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->status = 0;
            $user->save();

            // // Send Confirmation Message to the User (Only Work Online Server)
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'code' => base64_encode($data['email']),
            ];

            Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
                $message->to($email)->subject("Confirm Your stylooworld account");
            });

            // Redirect Back 
            $message = "Please confirm your email to activate your account!";

            return response()->json(['status' => true, 'message' => $message], 201);
        }
    }

    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' =>  implode(',', $validator->errors()->all()), "status" => false], 200);
            }


            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

                $message = "Welcome to dashboard";
                $userDetails = User::where('email', $data['email'])->get();
                return response()->json(['status' => true, 'message' => $message, 'user detail', $userDetails], 200);
            } else {
                $message = "Invalid Username or Password";

                return response()->json(['status' => false, 'message' => $message], 200);
            }
        }
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            // Validate Email                           
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' =>  implode(',', $validator->errors()->all())], 200);
            }

            $emailCount = User::where('email', $data['email'])->count();
            if ($emailCount == 0) {

                $message = "Email does not exists!";
                return response()->json(['status' => false, 'message' => $message], 200);
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
                $message->to($email)->subject("New password - stylooworld.info");
            });

            // Redirect to login/register page with success message
            $message = "Please check your email for new Password!";
            return response()->json(['status' => true, 'message' => $message], 200);
        }
    }

    // User Account Details
    public function acountDetails($id)
    {
        if (!empty($id)) {
            $ordersCount = Order::where('user_id', $id)->count();
            $reminderListDetails = Reminderlist::where('user_id', $id)->count();
            $user_id = $id;
            $userDetails = User::find($user_id)->toArray();
            if ($user_id ==  $userDetails['id']) {
                return response()->json(['status' => true, 'userDetails' => $userDetails, 'userOrders' => $ordersCount, 'ReminderListItems' => $reminderListDetails], 200);
            } else {
                $message = "No User Details is Found!";
                return response()->json(['status' => false, 'message' => $message], 200);
            }
        } else {

            $message = "No User Details is Found!";
            return response()->json(['status' => false, 'message' => $message], 200);
        }
    }

    // User Edit Account
    public function userEditAccount(Request $request, $id)
    {

        if ($request->isMethod('put')) {
            $userData = $request->input();

            // echo "<pre>";
            // print_r($userData);
            // die;

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

            $validator = Validator::make($userData, $rules, $customMessage);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' =>  implode(',', $validator->errors()->all())], 200);
            }

            User::where('id', $id)->update(['name' => $userData['name'], 'mobile' => $userData['mobile'], 'country' => $userData['country'], 'city' => $userData['city'], 'pincode' => $userData['pincode'], 'address' => $userData['address']]);

            $message = "Your account details has been updated successfully!";
            return response()->json(['status' => true, 'message' => $message], 202);
        }
    }

    // Update Password
    public function userUpdatePassword(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $data = $request->input();
            // echo "<pre>";
            // print_r($data);
            // die;
            $rules = [
                'new_pwd' => [
                    'required',
                    'string',
                    'min:8',
                    'max:30',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            ];

            $customMessages = [
                'new_pwd.required' => 'Password is required',
                'new_pwd.string' => 'Password must be string',
                'new_pwd.regex' => 'Password must contain letters,uppercase and lowercase letters, atleast one digits, and special characters',
            ];

            $validator = Validator::make($data, $rules, $customMessages);

            if ($validator->fails()) {
                return response(['status' => false, 'message' => implode(',', $validator->errors()->all())], 200);
            }


            $chkPassword = User::select('password')->where('id', $id)->first();
            if (Hash::check($data['current_pwd'], $chkPassword->password)) {
                // updated current password
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    $new_pwd = bcrypt($data['new_pwd']);
                    User::where('id', $id)->update(['password' => $new_pwd]);
                    $message = "Password updated successfully!";

                    return response()->json(['status' => true, 'message' => $message], 202);
                } else {
                    $message = "Passwords not match!";
                    return response()->json(['status' => false, 'message' => $message], 200);
                }
            } else {
                $message = "Current password is incorrect!";
                return response()->json(['status' => false, 'message' => $message], 200);
            }
        }
    }

    //Contact us
    public function contactUs(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email',
                'subject' => 'required|regex:/^[\pL\s\-]+$/u',
                'message' => 'required',
            ];

            $customMessages = [
                'name.required' => 'Name is required',
                'name.regex' => 'Name must be alphabet letters',
                'email.required' => 'Email is required!',
                'email.email' => 'Valid email is required',
                'subject.required' => 'Subject is required',
                'subject.regex' => 'Subject must be alphabet letters',
                'message.required' => 'Message is required',
            ];

            $validator = Validator::make($data, $rules, $customMessages);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => implode(',', $validator->errors()->all())], 200);
            }

            //contact data save

            $contact = new ContactUs;
            $contact->name = $data['name'];
            $contact->subject = $data['subject'];
            $contact->email = $data['email'];
            $contact->message = $data['message'];
            $contact->status = 'Unseen';
            $contact->save();
        }

        $message = "Your message is successfully delivered! Please checkout email for more information. Our team will response on email as soon as possible ";
        return response()->json(['status' => true, 'message' => $message], 200);
    }


    // Orders Details
    public function orderDetails($user_id)
    {
        $orderDetails = Order::with('orders_products')->where('user_id', $user_id)->get()->toArray();
        $ordersCount = Order::where('user_id', $user_id)->count();
        $reminderListDetails = Reminderlist::where('user_id', $user_id)->count();

        return response()->json(['status' => true, 'TotalOrders' => $ordersCount, 'Reminder_Items' => $reminderListDetails, 'order_details' => $orderDetails], 200);
    }

    // Coupon Notification API
    public function couponNotification()
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
            $coupon = Coupon::where(['users' => ''])->orderBy('id', 'Desc')->where('status', 1)->whereDate('expiry_date', '>', (new DateTime)->format('Y-m-d'))->get()->toArray();

            $couponCategory = Coupon::select('categories')->where('expiry_date', '>', $dt)->where('status', 1)->get();
            $couponsCat = explode(',', $couponCategory);

            $categoriesDetails = Category::select('category_name')->whereIn('id', $couponsCat)->whereNotIn('parent_id', [0, 0])->get()->pluck('category_name');

            // echo "<pre>";
            // print_r($coupon);
            // die;

            return response()->json(['status' => true, 'totalnotification ' => $couponAvailable, 'coupon' => $coupon, 'categories' => $categoriesDetails], 200);
        }
        return response()->json(['status' => true, 'No Notification'], 200);
    }
}
