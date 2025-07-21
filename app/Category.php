<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function subcategories()
    {
        return $this->hasMany('App\Category', 'parent_id')->where('status', 1);
    }

    // Basically these are the Database queries

    public function section()
    {
        //make blongs relation that this subcategory belongs to this category
        return $this->belongsTo('App\Section', 'section_id')->select('id', 'name');
    }

    public function parentCategory()
    {
        //make blongs relation that this subcategory belongs to this category
        return $this->belongsTo('App\Category', 'parent_id')->select('id', 'category_name');
    }

    public static function catDetails($url)
    {
        $catDetails = Category::select('id', 'parent_id', 'category_name', 'discription')->with(['subcategories' => function ($query) {
            $query->select('id', 'parent_id', 'category_name', 'discription')->where('status', 1);
        }])->where('category_name', $url)->first()->toArray();
        // dd($categoryDetails);
        // die;

        if ($catDetails['parent_id'] == 0) {
            //only show the main category in breadcumbs

            $breadcumbs = '<a href="' . url($catDetails['category_name']) . '" >' . $catDetails['category_name'] . '</a>';
        } else {
            //show main and sub categories in breadcumbs
            $parentCategory = Category::select('category_name', 'category_name')->where('id', $catDetails['parent_id'])->first()->toArray();
            $breadcumbs = '<a href="' . url($parentCategory['category_name']) . '" >' . $parentCategory['category_name'] . '</a>&nbsp;/&nbsp;<a href="' . url($catDetails['category_name']) . '" >' . $catDetails['category_name'] . '</a>';
        }

        $catIds = array();
        $catIds[] = $catDetails['id'];  //getting the parent id
        foreach ($catDetails['subcategories'] as $key => $subCat) {
            $catIds[] = $subCat['id']; // getting the subcategories along the parent categories
        }
        // dd($catIds);
        // die;
        return array('catIds' => $catIds, 'catDetails' => $catDetails, 'breadcumbs' => $breadcumbs,);
    }
}
