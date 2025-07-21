<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\ProductsAttribute;

class Cart extends Model
{
    use HasFactory;

    public static function userCartItems()
    {
        if (Auth::check()) {
            $userCartItems = Cart::with(['product' => function ($quary) {
                $quary->select('id', 'category_id', 'product_name',  'main_image');
            }, 'color', 'size'])->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
        } else {
            $userCartItems = Cart::with(['product' => function ($quary) {
                $quary->select('id', 'category_id', 'product_name',  'main_image');
            }, 'color', 'size'])->where('session_id', Session::get('session_id'))->orderBy('id', 'Desc')->get()->toArray();
        }

        return $userCartItems;
    }


    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function color()
    {
        return $this->belongsTo('App\ProductColor', 'color');
    }

    public function size()
    {
        return $this->belongsTo('App\ProductsAttribute', 'size');
    }

    public static function getProductAttrPrice($product_id, $size)
    {
        $attrPrice = ProductsAttribute::select('price')->where(['product_id' => $product_id, 'size' => $size])->first()->toArray();
        // echo "<pre>";
        // print_r($attrPrice);
        // die;
        return $attrPrice['price'];
    }
}
