<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Section extends Model
{
    // section categories relationship
    public function categories()
    {
        return $this->hasMany('App\Category', 'section_id')->where(['parent_id' => 'ROOT', 'status' => 1])->with('subcategories'); //with subcategories from category model relation function 
    }

    // section categories relationship
    public function product_categories()
    {
        return $this->hasMany('App\Category', 'section_id')->where(['parent_id' => 'ROOT', 'status' => 1])->with('subcategories'); //with subcategories from category model relation function 
    }

    // section categories relationship
    public function parent_categories()
    {
        return $this->hasMany('App\Category', 'section_id')->where(['parent_id' => 'ROOT', 'status' => 1])->with('subcategories'); //with subcategories from category model relation function 
    }

    //Get All About Section,Categories,and subcategories (to access in header aswell)
    public static function sections()
    {
        $getSections = Section::with('categories')->where('status', 1)->get();
        $getSections = json_decode(json_encode($getSections), true);
        // echo "<pre>";
        // print_r($getSections);
        // die;
        return $getSections;
    }
}
