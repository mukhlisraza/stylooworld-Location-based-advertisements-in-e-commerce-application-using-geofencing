<?php

namespace App\Http\Controllers\Front;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Product;
use App\Review;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
{
    //
    public function vendorShop($id)
    {
        // Getting New Products

        Session::put('page', 'shop');
        Paginator::useBootstrap();
        $newProducts  = Product::with(['section', 'vendor'])
            ->orderBy('id', 'Desc')
            ->where('status', 1)
            ->inRandomOrder()
            ->where('vendor_id', $id);
        $newProducts = $newProducts->paginate(9);
        $productsCount = Product::where('vendor_id', $id)->count();

        // echo "<pre>";
        // print_r($newProducts);
        // die;
        $vendorDetails = Admin::where('id', $id)->first();
        // echo "<pre>";
        // print_r($vendorDetails);
        // die;
        return view('front.vendor.shop')->with(compact("newProducts", 'productsCount', 'vendorDetails'));
    }

    public function shopProfile($id)
    {
        Session::put('page', 'vendor_profile');
        $productsCount = Product::where('vendor_id', $id)->count();
        $vendorDetails = Admin::where('id', $id)->first();

        $join = Admin::selectRaw('year(created_at) year, monthname(created_at) month, count(*) day')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->where('id', $id)
            ->first();
        // echo "<pre>";
        // print_r($join);
        // die;
        $productReview = Review::where('vendor_id', $id)->orderBy('id', 'Desc')->get()->toArray();
        $reviewCounts = Review::where('vendor_id', $id)->count();
        // dd($productReview);
        // die;
        $rating = Review::where('vendor_id', $id)->select('rating')->sum('rating');
        $totalReview = Review::where('vendor_id', $id)->select('rating')->count();
        if ($totalReview > 0) {
            $totalRating = $rating / $totalReview;
        } else {
            $totalRating = 0;
        }
        // dd($totalRating);
        // die;
        return view('front.vendor.shop_profile')->with(compact('vendorDetails', 'productsCount', 'join', 'productReview', 'reviewCounts', 'totalRating'));
    }
}
