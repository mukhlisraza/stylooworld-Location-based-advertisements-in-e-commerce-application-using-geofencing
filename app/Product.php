<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // category relation with product fatch from db
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    // section relation with product fatch from db
    public function section()
    {
        return $this->belongsTo('App\Section', 'section_id');
    }

    // vendor relation with product fatch from db
    public function vendor()
    {
        return $this->belongsTo('App\Admin', 'vendor_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    // Products has many attributes
    public function attributes()
    {
        return $this->hasMany('App\ProductsAttribute');
    }

    // Products has many attributes
    public function colors()
    {
        return $this->hasMany('App\ProductColor');
    }

    // Order Products
    public function order_products()
    {
        return $this->hasMany('App\OrdersProduct');
    }

    // Products has many images
    public function images()
    {
        return $this->hasMany('App\ProductsImage');
    }

    // Product has many reviews
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
    //Display products total at admin dashbaord
    public static function products()
    {
        $getProducts = Product::get()->where('status', 1);
        // $getProducts = json_decode(json_encode($getProducts), true);
        return $getProducts;
    }

    public static function productFilters()
    {
        // Filter Arrays
        $productFilters['fabricArray'] = array('Cotton', 'Polyester', 'Wool');
        $productFilters['sleeveArray'] = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $productFilters['patternArray'] = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        $productFilters['fitArray'] = array('Regular', 'Slim');
        $productFilters['occasionArray'] = array('Casual', 'Formal');

        return $productFilters;
    }

    public static function getDiscountedPrice($product_id)
    {
        $proDetails = Product::select('product_price', 'category_id')->where('id', $product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();


        if ($catDetails['category_discount'] > 0) {
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price'] * $catDetails['category_discount'] / 100);
        } else {
            $discounted_price = 0;
        }
        return $discounted_price;
    }

    public static function getDiscountedAttrPrice($product_id, $size)
    {
        $proAttrPrice = ProductsAttribute::where(['product_id' => $product_id, 'id' => $size])->first()->toArray();
        $proDetails = Product::select('category_id')->where('id', $product_id)->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();


        if ($catDetails['category_discount'] > 0) {
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] * $catDetails['category_discount'] / 100);
            $discount = $proAttrPrice['price'] - $final_price;
        } else {
            $final_price = $proAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price' => $proAttrPrice['price'], 'final_price' => $final_price, 'discount' => $discount);
    }

    // Product Image
    public static function getProductImage($product_id)
    {
        $getProductImage = Product::select('main_image')->where('id', $product_id)->first()->toArray();
        return $getProductImage['main_image'];
    }
}
