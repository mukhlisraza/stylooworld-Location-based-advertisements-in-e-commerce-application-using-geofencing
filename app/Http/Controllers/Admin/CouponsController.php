<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Http\Request;
use App\Section;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;

class CouponsController extends Controller
{
    //
    public function coupons()
    {
        Session::put('page', 'coupons');

        $coupons = Coupon::orderBy('id', 'Desc')->get()->toArray();



        // $my_time = new DateTime();
        // $my_time->format('Y-m-d');
        $coupon = Coupon::select('expiry_date')->get()->toArray();

        $today_date = Carbon::now();
        $today_date->format('Y-m-d');
        // echo "<pre>";
        // print_r($coupon);
        // die;

        return view('admin.coupons.coupons')->with(compact('coupons', 'today_date', 'coupon'));
    }

    public function updateCouponStatus(Request $request)
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
            Coupon::where('id', $data['coupon_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'coupon_id' => $data['coupon_id']]);
        }
    }

    public function addEditCoupon(Request $request, $id = null)
    {
        if ($id == "") {
            $coupon = new Coupon;
            $setCats = array();
            $setUsers = array();
            $title = "Add Coupon";
            $message = 'Coupon Added Successfully!';
        } else {
            $coupon = Coupon::find($id);
            $setCats = explode(',', $coupon['categories']);
            $setUsers = explode(',', $coupon['users']);
            $title = "Edit Coupon";
            $message = 'Coupon Edit Successfully!';
        }


        if ($request->isMethod('post')) {
            $data = $request->all();


            // Laravel validations
            $rules = [

                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric',
                'categories' => 'required',
                'expiry_date' => 'required',
            ];
            $customMessage = [
                'coupon_option.required' => 'Select Coupon Option is required',
                'coupon_type.required' => 'Select Coupon Type is required',
                'amount_type.required' => 'Select Amount Type is required',
                'amount.required' => 'Enter Amount is required',
                'amount.numeric' => 'Enter valid amount is required',
                'categories.required' => 'Select Category is required',
                'expiry_date.required' => 'Enter Expiry Date is required',
            ];
            $this->validate($request, $rules, $customMessage);

            if (isset($data['users'])) {
                $users = implode(',', $data['users']); //use implode function to convert array into string
            } else {
                $users = "";
            }
            if (isset($data['categories'])) {
                $categories = implode(',', $data['categories']); //use implode function to convert array into string
            }
            if ($data['amount'] <= 0) {
                $message = "Please enter amount greater than zero";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if ($data['amount'] <= 0) {
                $message = "Please enter amount greater than zero";
                session::flash('error_message', $message);
                return redirect()->back();
            }


            if ($data['coupon_option'] == 'Automatic') {
                $coupon_code = Str::random(12);
            } else {
                if (empty($data['coupon_code'])) {
                    $message = "Please enter Coupon Code is missing!";
                    session::flash('error_message', $message);
                    return redirect('admin/coupons');
                }
                $coupon_code = $data['coupon_code'];
            }
            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 0;
            $coupon->save();

            Session::flash('success_message', $message);
            return redirect('admin/coupons');
        }

        // Quary to display sections with categories and subcategories
        // relation made at Section model
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true); // getting the complete array

        // Users
        $users = User::select('email')->where('status', 1)->get()->toArray();

        return view('admin.coupons.add_edit_coupon')->with(compact('title', 'coupon', 'categories', 'users', 'setCats', 'setUsers'));
    }

    public function deleteCoupon($id)
    {
        // Delete Banner

        Coupon::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Coupon has been deleted successfully!');
    }
}
