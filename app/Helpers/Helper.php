<?php

use App\Cart;
use App\Order;
use App\Reminderlist;
use App\Report;
use App\Review;
use App\User;
use App\Coupon;
use Illuminate\Support\Facades\Auth;

function totalCartItems()
{
    if (Auth::check()) {
        $user_id = Auth::user()->id;
        $totalCartItems = Cart::where('user_id', $user_id)->sum('quantity');
    } else {
        $session_id = Session::get('session_id');
        $totalCartItems = Cart::where('session_id', $session_id)->sum('quantity');
    }
    return $totalCartItems;
}

function totalReminderItems()
{
    // if (Auth::check()) {
    //     $user_id = Auth::user()->id;
    //     $totalReminderItems = Reminderlist::where('user_id', $user_id)->count();
    // }

    $data = -2;
    foreach (Cookie::get() as $key => $value) {
        $data++;
    }
    return $data;
}

function totalNotifications()
{
    $dt = new DateTime();
    $dt->format('Y-m-d');

    $couponAvailable = Coupon::where('expiry_date', '>', $dt)->where('status', 1)->get()->count();
    return $couponAvailable;
}

function totalOrder()
{
    $order = Order::get()->count();

    return $order;
}

function newOrder()
{
    $deliveredOrder = Order::where('order_status', 'New')->get()->count();
    return $deliveredOrder;
}

function deliveredOrder()
{
    $deliveredOrder = Order::where('order_status', 'Delivered')->get()->count();
    return $deliveredOrder;
}

function pendingOrder()
{
    $deliveredOrder = Order::where('order_status', 'Pending')->get()->count();
    return $deliveredOrder;
}

function processingOrder()
{
    $deliveredOrder = Order::where('order_status', 'In Process')->get()->count();
    return $deliveredOrder;
}

function cancelOrder()
{
    $deliveredOrder = Order::where('order_status', 'Cancelled')->get()->count();
    return $deliveredOrder;
}

function dispatchOrder()
{
    $deliveredOrder = Order::where('order_status', 'Dispatch')->get()->count();
    return $deliveredOrder;
}

function totalReviews()
{
    $totalReview = Review::count();
    return $totalReview;
}

function totalReports()
{
    $totalReport = Report::count();
    return $totalReport;
}

function totalActiveUsers()
{
    $totalactive = User::where('status', 1)->count();
    return $totalactive;
}
