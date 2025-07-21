<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Section;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;

class CategoryController extends Controller
{
    //
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with(['section', 'parentCategory'])->get();
        // $categories = json_decode(json_encode($categories), true);
        // echo "<pre>";
        // print_r($categories);
        // die;
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
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
            Category::where('id', $data['category_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null)
    {

        if ($id == "") {
            $title = "Add Category";
            // Add category functionality

            //if id is not get it will create a new 
            $category = new Category();
            $categorydata = array(); //empty array becuase we haven't id


            // for getting category level
            $getCategories = array();
            // echo "<pre>";
            // print_r($categorydata);
            // die;
            $message = "Category Added successfully!";
        } else {
            $title = "Edit Category";
            // Edit category functionality
            $categorydata = Category::where('id', $id)->first();
            // $categorydata = json_decode(json_encode($categorydata), true);
            // echo "<pre>";
            // print_r($categorydata);
            // die;

            //getting details of category level
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $categorydata['section_id']])->get();
            $getCategories = json_decode(json_encode($getCategories), true);
            // echo "<pre>";
            // print_r($getCategories);
            // die;

            $category = Category::find($id);
            $message = "Category updated successfully!";
        }

        //checking form data is comming or not?
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                'category_name' => 'required|min:3',
                'section_id' => 'required',

            ];
            $customMessage = [
                'category_name.required' => 'Category name is required',

                'section_id.required' => 'Category Section is required',


            ];
            $this->validate($request, $rules, $customMessage);

            // Checking Category Discount
            if ($data['category_discount'] < 0) {
                $message = "Category discount should be equal or greater than zero";
                session::flash('error_message', $message);
                return redirect()->back();
            }



            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->discription = $data['description'];

            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            Session::flash('success_message', $message);
            return redirect("admin/categories");
        }

        // Get All the Sections
        $getSections = Section::get();
        return view('admin.categories.add-edit-category')->with(compact('title', 'getSections', 'categorydata', 'getCategories'));
    }


    public function appendCategoriesLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $getCategories = Category::with('subcategories')->where(['section_id' => $data['section_id'], 'parent_id' => 0, 'status' => 1])->get();
            $getCategories = json_decode(json_encode($getCategories), true);
            // echo "<pre>";
            // print_r($getCategories);
            // die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }


    // Delete Category Image
    public function deleteCategoryImage($id)
    {
        //get category images that we want to delete
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        // get category image path
        $category_image_path = 'images/category_images/';

        // Delete Category image from category_images folder if exist
        if (file_exists($category_image_path . $categoryImage->category_image)) {
            unlink($category_image_path . $categoryImage->category_image);
        }

        // Delete category image from category table
        Category::where('id', $id)->update(['category_image' => '']);

        return redirect()->back()->with('flash_message_success', 'Category Image has been deleted successfully!');
    }


    //DElete Category

    public function deleteCategory($id)
    {
        // Delete category
        Category::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Category has been deleted successfully!');
    }
}
