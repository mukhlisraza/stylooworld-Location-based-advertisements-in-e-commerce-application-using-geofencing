<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrdersLog;
use App\OrderStatus;
use App\ReferrerSale;
use App\Sms;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class OrdersController extends Controller
{
    //
    public function orders()
    {
        Session::put('page', 'manageorders');
        $orders = Order::with(['orders_products' => function ($query) {
            $query->where('vendor_id', Auth::guard('admin')->user()->id);
        }])->orderBy('id', 'Desc')->get()->toArray();

        $ordersAdmin = Order::with('orders_products')->orderBy('id', 'Desc')->get()->toArray();
        // echo "<pre>";
        // print_r($orders);
        // die;
        return view('admin.orders.orders')->with(compact('orders', 'ordersAdmin'));
    }

    public function ordersDetails($id)
    {
        $orderDetails = Order::with(['orders_products' => function ($query) {
            $query->where('vendor_id', Auth::guard('admin')->user()->id);
        }])->where('id', $id)->first()->toArray();

        $orderDetailsAdmin = Order::with('orders_products')->where('id', $id)->first()->toArray();


        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        $orderStatus = OrderStatus::where('status', 1)->where('role_assign', 'vendor')->get()->toArray();
        $orderStatusAdmin = OrderStatus::where('status', 1)->where('role_assign', 'admin')->get()->toArray();

        $orderStatusAdminRole = OrderStatus::where('status', 1)->where('role_assign', 'admin')->get()->toArray();

        $orderLog = OrdersLog::where('order_id', $id)->get()->toArray();
        return view('admin.orders.order_details')->with(compact('orderDetails', 'orderDetailsAdmin', 'userDetails', 'orderStatus', 'orderStatusAdmin', 'orderLog'));
    }

    public function updateOrderStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // Updated Order Status
            Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);
            Session::flash('success_message', 'Order Status has been updated successfully!');


            // // Get User Details Here
            $deliveryDetails = Order::select('mobile', 'email', 'name')->where('id', $data['order_id'])->first()->toArray();

            if ($data['order_status'] == 'Delivered') {
                //Send Order Status SMS
                $message = "Dear Customer, your order #(" . $data['order_id'] . ") status has been updated to '" . $data['order_status'] . "'. Thanks for using stylooworld. If you have any issue let us update";
                $mobile = $deliveryDetails['mobile'];
                Sms::sendSms($message, $mobile);
            } else {
                //Send Order Status SMS
                $message = "Dear Customer, your order #(" . $data['order_id'] . ") status has been updated to '" . $data['order_status'] . "' Soon will be recieved";
                $mobile = $deliveryDetails['mobile'];
                Sms::sendSms($message, $mobile);
            }



            $orderDetails = Order::with('orders_products')->where('id', $data['order_id'])->first()->toArray();

            if ($data['order_status'] != 'New' || $data['order_status'] != 'Delivered to Store') {

                // Send Status Update Email
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'name' => $deliveryDetails['name'],
                    'order_id' => $orderDetails['order_id'],
                    'order_status' => $data['order_status'],
                    'orderDetails' => $orderDetails,
                ];

                Mail::send('emails.order_status', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Order Status Updated - stylooworld.info');
                });
            }

            // Update Order Log
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();


            $referreringData = DB::table('referrer_sales')
                ->join('orders', 'referrer_sales.order_id', '=', 'orders.order_id')
                ->get();

            foreach ($referreringData as $key => $value) {
                // $orderDetails[] = $value;
                if ($value->order_status == 'Cancelled') {
                    ReferrerSale::where(['referrer_id' => $value->referrer_id])
                        ->where(['order_amount' => $value->order_amount])
                        ->update(['commission' => 0]);
                }
            }

            return redirect()->back();
        }
    }

    public function viewOrderInvoice($id)
    {
        $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();

        return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
    }


    // Pending Orders
    public function pendingorders()
    {
        Session::put('page', 'pendingorders');
        $orders = Order::with('orders_products')->orderBy('id', 'Desc')->get()->toArray();
        // echo "<pre>";
        // print_r($orders);
        // die;
        return view('admin.orders.admin_pendingorders')->with(compact('orders'));
    }

    // Delivered Orders
    public function deliveredorders()
    {
        Session::put('page', 'deliveredorders');
        $orders = Order::with(['orders_products' => function ($query) {
            $query->where('vendor_id', Auth::guard('admin')->user()->id);
        }])->orderBy('id', 'Desc')->get()->toArray();

        return view('admin.orders.admin_deliveredorders')->with(compact('orders'));
    }
}
