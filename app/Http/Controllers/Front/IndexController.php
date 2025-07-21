<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\Controller;
use App\Index;
use Illuminate\Http\Request;
use App\Product;
use App\Reminderlist;
use App\Section;
use Illuminate\Support\Facades\Auth;

class IndexController extends Index
{
    //
    public function index()
    {
        // Getting Featured Products
        $featuredItemsCount = Product::where('is_featured', 'Yes')->where('status', 1)->count();
        $featuredItems = Product::where('is_featured', 'Yes')->where('status', 1)->inRandomOrder()->get()->toArray();
        // dd($featuredItems);
        // die;
        $featuredItemsChunk = array_chunk($featuredItems, 3);
        // dd($featuredItemsChunk);
        // die;

        // Getting New Products
        $newProducts  = Product::with(['section', 'vendor'])
            ->orderBy('id', 'Desc')
            ->where('status', 1)
            ->limit(12)
            ->inRandomOrder()
            ->get()
            ->toArray();
        // dd($newProducts);
        // die;

        // $reminderItem = Reminderlist::where('user_id', Auth::user()->id)->get()->toArray();
        // foreach ($reminderItem as $cat) {
        //     $categoryName[] = $cat['product_id'];
        // }
        // $categoryString = implode(',',  $categoryName);
        // // dd($categoryString);
        // // die;

        $page_name = 'index';
        return view('front.index')->with(compact('page_name', 'featuredItemsChunk', 'newProducts', 'featuredItemsCount',));
    }


    // Compare Products Code
    public function compareproduct()
    {
        return view('front.compareproducts');
    }


    // term condition
    public function termcondition()
    {
        return view('front.term-condition');
    }

    // Recent Orders

    public function recentorders()
    {
        return view('front.recentorders');
    }
}
