<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Admin;
use App\ContactUs;
use App\NewsletterSubcriber;
use App\ShopInformation;
use App\ShopTiming;
use Image;
use App\User;
use Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session as FacadesSession;

class AdminController extends Controller
{

    //********************** Admin Login **************** */

    public function login(Request $request)
    {
        if ($request->isMethod("post")) {

            // Custom Validations
            // $rules = [
            //     'email' => 'required|email|max:255',
            //     'password' => 'required',
            // ];
            // $customMessage = [
            //     'email.required' => 'Email is required',
            //     'email.email' => 'Valid email is required',
            //     'password.required' => 'Password is required',
            // ];
            // $this->validate($request, $rules, $customMessage);

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $data = $request->all();
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1, 'type' => 'admin'])) {
                return redirect('admin/dashboard');
            } else {

                Session::flash('error_message', "Enter valid email or password");
                return redirect()->back();
            }
        }

        return view('admin.admin_login');
    }
    // Admin Logout
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->user()->type == 'vendor') {
            Auth::guard('admin')->logout();
            $message = "Successfully logout!";
            Session::flash('success_message', $message);
            return redirect('/login');
        } elseif (Auth::guard('admin')->user()->type == 'admin') {
            Auth::guard('admin')->logout();
            $request->session()->flash('status', 'Successful Logout!');
            return redirect('/admin');
        }
    }


    // Admin Dashboard
    public function adminlogin()
    {
        Session::put('page', 'dashboard');
        $userCount = User::select('id')->where('status', 1)->get()->count();
        return view('admin.admin_dashboard')->with(compact('userCount'));
    }

    //**********************  Admin Profile **************** */ 
    public function admin_profile()
    {
        Session::put('page', 'profile');
        //Anather way to fectch admin details
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();

        return view('admin.admin_profile')->with(compact('adminDetails'));
    }

    //**********************  Checking current password **************** */ 
    public function chkCurrentPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    //**********************  Update Password **************** */ 
    public function updateCurrentPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'current_pwd' => 'required',
                'new_pwd' => 'required',
            ];

            $customMessages = [
                'current_pwd.required' => 'Current Password is required',
                'new_pwd.required' => 'New Password is required',
            ];

            $this->validate($request, $rules, $customMessages);



            // check if current password is correct
            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                //checking new and confirm password
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'Password update successfuly');
                } else {
                    Session::flash('error_message', 'New password and confirm password not match');
                }
            } else {
                Session::flash('error_message', 'Your current password is incorrect');
            }
            return redirect()->back();
        }
    }

    /******************** UPDATE ADMIN DETAILS ***************/

    public function updateAdminDetails(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'admin_name' => 'required|min:3|regex:/^[\pL\s\-]+$/u',

                'admin_mobile' => 'required|numeric|digits:11',
                'admin_image' => 'image',
            ];
            $customMessage = [
                'admin_name.required' => 'Name is required',

                'admin_mobile.required' => 'Mobile Number is required',
                'admin_mobile.numeric' => 'Valid mobile Number is required',
                'admin_image.image' => 'Valid image is required',
            ];
            $this->validate($request, $rules, $customMessage);

            //Upload Image
            if ($request->hasFile('admin_image') && Auth::guard('admin')->user()->type == 'admin') {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/admin_photos/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else if (!empty($data['current_admin_image'])) {
                    $imageName = $data['current_admin_image'];
                } else {
                    $imageName = "";
                }
            } else if ($request->hasFile('admin_image') && Auth::guard('admin')->user()->type == 'vendor') {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/admin_photos/vendor_photos/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else if (!empty($data['current_admin_image'])) {
                    $imageName = $data['current_admin_image'];
                } else {
                    $imageName = "";
                }
            }

            if (empty($request->hasFile('admin_image'))) {
                Session::flash('error_message', "please select image also");
                return redirect()->back();
            }
            //Update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'business_name' => $data['business_name'], 'business_address' => $data['business_address'], 'image' => $imageName]);
            Session::flash('success_message', "Details is successfully updated");
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }

    /******************** UPDATE ADMIN IMAGE ***************/

    public function updateAdminImage(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'admin_avatar_image' => 'image',
            ];
            $customMessage = [
                'admin_avatar_image.image' => 'Enter Valid Image',
            ];
            $this->validate($request, $rules, $customMessage);

            //Upload Image
            if ($request->hasFile('admin_avatar_image') && Auth::guard('admin')->user()->type == 'admin') {
                $image_tmp = $request->file('admin_avatar_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/admin_photos/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else {
                    $imageName = "";
                }
            } else if ($request->hasFile('admin_avatar_image') && Auth::guard('admin')->user()->type == 'vendor') {
                $image_tmp = $request->file('admin_avatar_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/admin_photos/vendor_photos/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->resize(300, 300)->save($imagePath);
                } else {
                    $imageName = "";
                }
            }
            //Update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['image' => $imageName]);
            Session::flash('success_message', "Details is successfully updated");
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }


    /******************** Conact Us ***************/
    public function contactusview()
    {
        Session::put('page', 'contactus');

        $allContact = ContactUs::get()->toArray();
        // dd($allContact);
        // die;
        return view('admin.admin_contactus')->with(compact('allContact'));
    }

    public function updateContactStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            // Updated contact Status
            ContactUs::where('id', $data['contact'])->update(['status' => $data['contact_status']]);
            Session::flash('success_message', 'Message Status has been updated successfully!');
            return redirect()->back();
        }
    }

    /******************** Vendor Registration  **********************/
    public function vendor()
    {
        Session::put('page', 'vendor');


        $vendorDetails = Auth::guard('admin')->user()->get()->toArray();

        // echo "<pre>";
        // print_r($vendorDetails);
        // die;

        return view('admin.admin_vendor')->with(compact('vendorDetails'));
    }

    public function registerVendor(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            // die;
            $rules = [
                'name' => 'required|min:3|regex:/^[\pL\s\-]+$/u',
                'business_name' => 'required|min:3',
                'business_address' => 'required',

                'phone' => 'required|numeric|digits:11',

            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'name.regex' => 'Name contain only characters',
                'business_name.required' => 'Business name is required',

                'business_address.required' => 'Business address is required',

                'phone.required' => 'Mobile Number is required',
                'phone.numeric' => 'Valid mobile Number is required',

            ];
            $this->validate($request, $rules, $customMessage);


            // Checking shop name 
            $businessName = Admin::where('business_name', $data['business_name'])->count();
            if ($businessName > 0) {
                $message = "Shop Already Register";
                session::flash('error_message', $message);
                return redirect()->back();
            }
            // checking account available or not
            $userCount = User::where('mobile', $data['phone'])->count();
            $vendorCount = Admin::where('mobile', $data['phone'])->count();
            if ($userCount > 0 || $vendorCount > 0) {
                $message = "Account Already Register";
                session::flash('error_message', $message);
                return redirect()->back();
            } else {


                $vendor = new Admin;
                $vendor->name = $data['name'];
                $vendor->business_name = $data['business_name'];
                $vendor->business_address = $data['business_address'];
                $vendor->mobile = $data['phone'];
                $vendor->email = $data['email'];
                $vendor->password = bcrypt($data['phone']);
                $vendor->type = 'vendor';
                $vendor->status = 1;
                $vendor->account_status = 0;
                // echo "<pre>";
                // print_r($vendor);
                // die;
                $vendor->save();

                $message = "Vendor Successfully Register!";
                Session::flash("success_message", $message);
                return redirect()->back();
            }
        }
    }

    // Update Status
    public function updateVendorStatus(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['vendor_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'vendor_id' => $data['vendor_id']]);
        }
    }

    //Delete vendor
    public function deleteVendor($id)
    {
        // Delete Product
        Admin::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Vendor has been deleted successfully!');
    }

    // Update User Status
    public function updateUserStatus(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            User::where('id', $data['user_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'user_id' => $data['user_id']]);
        }
    }

    //Delete user
    public function deleteUser($id)
    {
        // Delete Product
        User::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Vendor has been deleted successfully!');
    }


    // Password Recovery Code
    public function recoverycode()
    {
        return view('admin.admin_password-recoverycode');
    }

    // Active User
    public function activeuser()
    {
        Session::put('page', 'active_user');


        $getUser = User::get()->toArray();
        $getVendor = Admin::where('type', 'vendor')->get()->toArray();
        $users =  array_merge($getVendor, $getUser);
        // dd($users);
        // die;
        return view('admin.admin_activeuser')->with(compact('users'));
    }


    // Admin forgorpassword
    public function passwordforgot()
    {
        return view('admin.admin_forgot-password');
    }

    // Forget password recovery
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $emailCount = Admin::where('email', $data['email'])->count();
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
            Admin::where('email', $data['email'])->update(['password' => $new_password]);

            // Get Forgot Password Email
            $userName = Admin::select('fname')->where('email', $data['email'])->first();

            // Send Forgot Password Email
            $email = $data['email'];
            $name = $userName->fname;
            $messageData = [
                'email' => $email,
                'fname' => $name,
                'password' => $random_password,
            ];
            Mail::send('emails.admin-forgot-password', $messageData, function ($message) use ($email) {
                $message->to($email)->subject("New password - stylooworld.info");
            });

            // Redirect to login/register page with success message
            $message = "Please check your email for new Password!";
            Session::flash('success_message', $message);
            return redirect('/admin');
        }
        return view('admin.admin_forgot-password');
    }



    // // Deactive User
    // public function deactiveuser()
    // {
    //     Session::put('page', 'deactive_user');

    //     $getUser = User::where('status', 0)->get()->toArray();
    //     $getVendor = Admin::where('type', 'vendor')->where('status', 0)->get()->toArray();
    //     $users =  array_merge($getVendor, $getUser);
    //     // dd($users);
    //     // die;

    //     return view('admin.admin_deactiveuser')->with(compact('users'));
    // }


    // Deactive User
    public function subscriberuser()
    {
        Session::put('page', 'subscriberuser');

        $getSubscriberUser = NewsletterSubcriber::get()->toArray();
        // echo "<pre>";
        // print_r($getSubscriberUser);
        // die;
        return view('admin.admin_subscriberuser')->with(compact('getSubscriberUser'));
    }

    // Product Gallery (belongs to product page)
    public function productgallery()
    {
        return view('admin.admin_productgallery');
    }

    // Shop infor
    public function shopinfo()
    {
        Session::put('page', 'shopinfo');

        $shop = ShopInformation::get()->toArray();
        $shopTime = ShopTiming::get()->toArray();
        // dd($shopTime);
        // die;
        return view('admin.shopinfo')->with(compact('shop', 'shopTime'));
    }
    /*
    public function addEditShopInfo(Request $request, $id = null)
    {

        $title = "Edit Shop Information";
        $shopinfos = ShopInformation::find($id);
        //checking form data is comming or not?
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'min:3|regex:/^[\pL\s\-]+$/u',
                'email' => 'email',
                'mobile' => 'numeric|digits:11',

            ];
            $customMessage = [
                'name.regex' => 'First Name contain only characters',
                'mobile.numeric' => 'Valid mobile Number is required',
            ];
            $this->validate($request, $rules, $customMessage);



            ShopInformation::where('id', $id)->update(['name' => $data['name'], 'address' => $data['address'], 'mobile' => $data['mobile'], 'email' => $data['email']]);

            $message = "Information successfully updated";
            Session::flash('success_message', $message);
            return redirect('admin/shopinfo');
        }

        return view('admin.addEditShopInfo')->with(compact('title', 'shopinfos'));
    }

    public function addEditShopTime(Request $request, $id = null)
    {
        $title = "Edit Shop Timing";
        $shopTime = ShopTiming::find($id);

        // echo "<pre>";
        // print_r($shopTime);
        // die;

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            ShopTiming::where('id', $id)->update([
                "sunday_from" => $data['sunday_from'],
                "sunday_to" => $data['sunday_to'],
                "monday_from" => $data['monday_from'],
                "monday_to" => $data['monday_to'],
                "tuesday_from" => $data['tuesday_from'],
                "tuesday_to" => $data['tuesday_to'],
                "wednesday_from" => $data['wednesday_from'],
                "wednesday_to" => $data['wednesday_to'],
                "thursday_from" => $data['thursday_from'],
                "thursday_to" => $data['thursday_to'],
                "friday_from" => $data['friday_from'],
                "friday_to" => $data['friday_to'],
                "saturday_from" => $data['saturday_from'],
                "saturday_to" => $data['saturday_to'],
            ]);

            $message = "Information successfully updated";
            Session::flash('success_message', $message);
            return redirect('admin/shopinfo');
        }
        return view('admin.addEditShopTiming')->with(compact('title', 'shopTime'));
    }
*/
    // Account reset password rout 
    public function adminAccountResetPassword()
    {
        return view('admin.accountResetPassowrd');
    }

    public function accountReset(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $rules = [
                'password' => 'required',
            ];

            $customMessages = [
                'password.required' => 'Password is required',
            ];

            $this->validate($request, $rules, $customMessages);

            // match password again
            if ($data['password'] != $data['password_again']) {
                $message = "Password not match, Please enter password same";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['password_again']), 'account_status' => 1]);

            $message = "Password is successfully change!";
            Session::flash('success_message', $message);
            return redirect('admin/dashboard');
        }
    }
}
