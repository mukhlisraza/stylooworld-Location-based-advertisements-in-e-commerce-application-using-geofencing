<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductColor;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Report;
use App\Review;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;

class ProductsController extends Controller
{
    //

    public function products()
    {

        Session::put('page', 'product');
        // $products = Product::with(['Category', 'Section'])->get(); // getting all the products enable and disables etc.
        /******  OR ******/
        //Can also use subquary not to fatch every data just fetch the require one

        $products = Product::with(['Category' => function ($query) {
            //subqueries
            $query->select('id', 'category_name');
        }, 'Section' => function ($query) {
            $query->select('id', 'name');
        }])->where('vendor_id', Auth::guard('admin')->user()->id)->orderBy('id', 'Desc')->get();
        // $products = json_decode(json_encode($products), true);
        // echo "<pre>";
        // print_r($products);
        // die;
        return view('admin.products.admin_products')->with(compact('products'));
    }

    // Update Status
    public function updateProductStatus(Request $request)
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
            Product::where('id', $data['product_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'category_id' => $data['product_id']]);
        }
    }

    //Delete Product

    public function deleteProduct($id)
    {
        // Delete Product
        Product::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Product has been deleted successfully!');
    }

    //Add Edit Product
    public function addEditProduct(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add Product";
            $product = new Product;

            $productdata = array(); //we can simply declare empty array b/c if not it can create issue in edit
            $message = 'Product Added Successfully!';
        } else {
            $title = "Edit Product";

            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata), true);
            // echo "<pre>";
            // print_r($productdata);
            // die;
            $product = Product::find($id);
            $message = 'Product Edit Successfully!';
        }


        //checking form data is comming or not?
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            // Laravel validations
            $rules = [
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_name' => 'required',
                'product_price' => 'required|numeric',
                'product_Actual_price' => 'required|numeric',
                'product_weight' => 'required|numeric',
                'category_image' => 'image',
                'product_video' => 'mimes:mp4,mov,ogg,qt',

            ];
            $customMessage = [
                'category_id.required' => 'Category is required',
                'brand_id.required' => 'Brand is required',
                'product_name.required' => 'Product name is required',

                'product_price.required' => 'Product price is required',
                'product_price.numeric' => 'Valid product price is required',

                'product_Actual_price.required' => 'Product price is required',
                'product_Actual_price.numeric' => 'Valid product price is required',

                'product_weight.required' => 'Product weight is required',
                'product_weight.numeric' => 'Valid product weight price is required',

                'product_video.mimes' => 'Valid product type is required',

            ];
            $this->validate($request, $rules, $customMessage);


            // save product details in product table
            $categoryDetails = Category::find($data['category_id']);
            // echo "<pre>";
            // print_r($categoryDetails);
            // die;

            if (empty($data['is_featured'])) {
                $is_featured = "No";
            } else {
                $is_featured = "Yes";
            }

            // Checking Product Price Should not be less than zero
            if ($data['product_price'] <= 0) {
                $message = "Product price should be greate than zero";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            // Checking Product discount should not be less than product price
            // if ($data['product_discount'] > $data['product_price']) {
            //     $message = "Product discount should not be greater than product price";
            //     session::flash('error_message', $message);
            //     return redirect()->back();
            // }
            // if ($data['product_discount'] < 0) {
            //     $message = "Product discount should equal or greater than zero";
            //     session::flash('error_message', $message);
            //     return redirect()->back();
            // }

            //Upload Product Images 
            if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    //upload image after resize
                    //Get Image Extension
                    $image_name = $image_tmp->getClientOriginalName(); //get the image name
                    $extension = $image_tmp->getClientOriginalExtension(); //get extention of the image
                    $imageName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/product_images/large/' . $imageName;
                    $medium_image_path = 'images/product_images/medium/' . $imageName;
                    $small_image_path = 'images/product_images/small/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->save($medium_image_path);
                    Image::make($image_tmp)->save($small_image_path);
                    $product->main_image = $imageName; // save name in database table products column main_image

                }
            }
            //End upload images

            //Upload Product Video
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($image_tmp->isValid()) {

                    //Get video Extension
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name . '-' . rand() . '.' . $extension;
                    $video_path = 'videos/product_videos';
                    $video_tmp->move($video_path, $videoName);
                    $product->product_video = $videoName;
                }
            }
            //End upload Video

            $product->vendor_id = Auth::guard('admin')->user()->id;
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->product_name = $data['product_name'];
            // $product->product_code = $data['product_code'];
            // $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_actual_price = $data['product_Actual_price'];
            $product->product_weight = $data['product_weight'];
            // $product->product_discount = $data['product_discount'];
            // $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            // $product->fabric = $data['fabric'];
            // $product->pattern = $data['pattern'];
            // $product->sleeve = $data['sleeve'];
            // $product->fit = $data['fit'];
            // $product->occasion = $data['occasion'];

            $product->meta_keywords = $data['meta_keywords'];

            $product->is_featured = $is_featured;
            $product->status = 1; //add status by default active
            $product->save();

            session::flash('success_message', $message);
            return redirect("admin/products");
        }
        // Filter Arrays
        $productFilters = Product::productFilters();
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];

        // Quary to display sections with categories and subcategories
        // relation made at Section model
        $categories = Section::with('product_categories')->where('status', 1)->get();
        $categories = json_decode(json_encode($categories), true); // getting the complete array
        // echo "<pre>";
        // print_r($categories);
        // die;

        //Get All Brands
        $brands = Brand::where('status', 1)->get();
        $brands = json_decode(json_encode($brands), true); // getting the complete array


        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories', 'productdata', 'title', 'brands'));
    }



    // Delete product images
    public function deleteProductImage($id)
    {
        //get product images that we want to delete
        $productImage = Product::select('main_image')->where('id', $id)->first();

        // get product images path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        // Delete product image from product_images folder if exist
        if (file_exists($small_image_path . $productImage->main_image)) {
            unlink($small_image_path . $productImage->main_image);
        }
        // Delete product image from product_images folder if exist
        if (file_exists($medium_image_path . $productImage->main_image)) {
            unlink($medium_image_path . $productImage->main_image);
        }
        // Delete product image from product_images folder if exist
        if (file_exists($large_image_path . $productImage->main_image)) {
            unlink($large_image_path . $productImage->main_image);
        }

        // Delete product image from product table
        Product::where('id', $id)->update(['main_image' => '']);
        return redirect()->back()->with('flash_message_success', 'Product Image has been deleted successfully!');
    }

    // Delete product video
    public function deleteProductVideo($id)
    {
        //get product video that we want to delete
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        // get product video path
        $product_video_path = 'videos/product_videos/';

        // Delete product video from product_videos folder if exist
        if (file_exists($product_video_path . $productVideo->product_video)) {
            unlink($product_video_path . $productVideo->product_video);
        }

        // Delete product video from product table 
        Product::where('id', $id)->update(['product_video' => '']);
        return redirect()->back()->with('flash_message_success', 'Product Video has been deleted successfully!');
    }

    /*************************** Products Attributes ************************/
    public function addAttributes(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            foreach ($data['size'] as $key => $value) {
                if (!empty($value)) {

                    //size already exits validation
                    $attrCountSize = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSize > 0) {
                        $message = "Size Already Exit. Please Add Another Size";
                        session::flash("error_message", $message);
                        return redirect()->back();
                    }

                    if ($data['price'][$key] <= 0) {
                        $message = "Price should be greater than 0";
                        Session::flash("error_message", $message);
                        return redirect()->back();
                    }
                    if ($data['stock'][$key] < 0) {
                        $message = "Stock should be equal or greater than 0";
                        Session::flash("error_message", $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    // $attribute->sku = $value;
                    $attribute->size = $value;
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $success_message = "Product attributes has been added successfully!";
            session::flash("attSuccess_message", $success_message);
            return redirect()->back();
        }
        $productdata = Product::select('id', 'product_name', 'main_image')->with(['attributes', 'colors'])->find($id);
        $productdata = json_decode(json_encode($productdata), true);

        $attributeColor = ProductColor::where('product_id', $id)->get();
        // echo "<pre>";
        // print_r($id);
        // die;
        $title = "Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata', 'title'));
    }

    /*************************** Products Attributes ************************/

    public function addAttributeColors($attribute_id)
    {
        $productdata = ProductsAttribute::find($attribute_id)->toArray();
        $attributeColor = ProductColor::where('size_id', $attribute_id)->get();
        $productID = ProductsAttribute::select('product_id')->find($attribute_id);
        // echo "<pre>";
        // print_r($attributeColor);
        // die;

        $title = "Product Attributes Colors";
        return view('admin.products.add_attributes_colors')->with(compact('productdata', 'title', 'attributeColor', 'productID'));
    }

    public function addColor(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            foreach ($data['size'] as $key => $value) {
                if (!empty($value)) {

                    //size already exits validation
                    $attrCountSize = ProductColor::where(['product_id' => $id, 'color' => $data['size'][$key]])->count();
                    if ($attrCountSize > 0) {
                        $message = "Color already exit. Please add another color";
                        session::flash("error_message", $message);
                        return redirect()->back();
                    }


                    if ($data['stock'][$key] < 0) {
                        $message = "Stock should be equal or greater than 0";
                        Session::flash("error_message", $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductColor;
                    $attribute->product_id = $data['product_id'];
                    $attribute->size_id = $id;
                    $attribute->size = $data['product_attribute_size'];
                    // $attribute->sku = $value;
                    $attribute->color = $value;
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $success_message = "Product colors has been added successfully!";
            session::flash("attSuccess_message", $success_message);
            return redirect()->back();
        }
        $productdata = Product::select('id', 'product_name', 'main_image')->with(['attributes', 'colors'])->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        echo "<pre>";
        print_r($productdata);
        die;
        $title = "Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata', 'title'));
    }

    public function deleteColor($id)
    {
        // Delete Attribute
        ProductColor::where('id', $id)->delete();
        $message = 'Product Attribute Color has been deleted successfully!';
        session::flash('success_message', $message);
        return redirect()->back();
    }


    public function editAttributes(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            foreach ($data['attrId'] as $key => $attr) {
                if (!empty($attr)) {
                    if ($data['price'][$key] <= 0) {
                        $message = "Price should be greater than 0";
                        Session::flash("error_message", $message);
                        return redirect()->back();
                    }
                    if ($data['stock'][$key] < 0) {
                        $message = "Stock should be equal or greater than 0";
                        Session::flash("error_message", $message);
                        return redirect()->back();
                    }

                    ProductsAttribute::where(['id' => $data['attrId'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
                }
                // echo "<pre>";
                // print_r($data);

            }
            // die;
            $success_message = "Product attributes has been updated successfully!";
            session::flash("attSuccess_message", $success_message);
            return redirect()->back();
        }
    }

    /**************************** Attribute Status  **********************/
    public function updateAttributeStatus(Request $request)
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
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'attribute_id' => $data['attribute_id']]);
        }
    }

    /********************************* Delete Attributes ******************************/


    public function deleteAttribute($id)
    {
        // Delete Attribute
        ProductsAttribute::where('id', $id)->delete();
        $message = 'Product Attribute has been deleted successfully!';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    /********************************* Add Product Images ***************************/
    public function addImages(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($request->hasFile('images')) {
                //check images or not
                $images = $request->file('images');
                foreach ($images as $key => $image) {
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111, 999999) . time() . "." . $extension;
                    $large_image_path = 'images/product_images/large/' . $imageName;
                    $medium_image_path = 'images/product_images/medium/' . $imageName;
                    $small_image_path = 'images/product_images/small/' . $imageName;
                    //Upload Image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->save($medium_image_path);
                    Image::make($image_tmp)->save($small_image_path);
                    $productImage->image = $imageName;
                    $productImage->product_id = $id; //geting the product id in which images added 
                    $productImage->status = 1;
                    $productImage->save();
                }
                $success_message = "Product Image has been updated successfully!";
                session::flash("success_message", $success_message);
                return redirect()->back();
            }
        }
        $productdata = Product::with('images', 'attributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>";
        // print_r($productdata);
        // die;
        return view('admin.products.add-images')->with(compact('productdata'));
    }

    /**************************** Image Status  **********************/
    public function updateImageStatus(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();
            // $data = json_decode(json_encode($data), true);
            // echo "<pre>";
            // print_r($data);
            // die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsImage::where('id', $data['image_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'image_id' => $data['image_id']]);
        }
    }

    /********************************* Delete Image ******************************/

    public function deleteImage($id)
    {
        //get product images that we want to delete
        $productImage = ProductsImage::select('image')->where('id', $id)->first();

        // get product images path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        // Delete product image from product_images folder if exist
        if (file_exists($small_image_path . $productImage->image)) {
            unlink($small_image_path . $productImage->image);
        }
        // Delete product image from product_images folder if exist
        if (file_exists($medium_image_path . $productImage->image)) {
            unlink($medium_image_path . $productImage->image);
        }
        // Delete product image from product_images folder if exist
        if (file_exists($large_image_path . $productImage->image)) {
            unlink($large_image_path . $productImage->image);
        }

        // Delete product image from product table
        ProductsImage::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Product Image has been deleted successfully!');
    }

    /************************* Product Report *******************************/
    public function proreport()
    {
        Session::put('page', 'report');

        $allReport = Report::select()->get()->toArray();
        // dd($allReport);
        // die;
        return view('admin.admin_report')->with(compact('allReport'));
    }

    // stock
    public function stock()
    {
        Session::put('page', 'stock');

        $products = Product::with(['attributes', 'Category', 'Section', 'order_products'])->where('vendor_id', Auth::guard('admin')->user()->id)->orderBy('id', 'Desc')->get()->toArray();

        return view('admin.products.admin_stocks')->with(compact('products'));
    }

    // Reviews 
    public function review()
    {
        Session::put('page', 'review');

        $products = Product::with(['attributes', 'Category', 'Section', 'order_products', 'reviews'])->where('vendor_id', Auth::guard('admin')->user()->id)->orderBy('id', 'Desc')->get()->toArray();

        // echo "<pre>";
        // print_r($products);
        // die;
        return view('admin.products.product_reviews')->with(compact('products'));
    }

    // Reviews Show 
    public function reviewsDetails($id)
    {
        $products = Product::with(['attributes', 'Category', 'Section', 'order_products', 'reviews'])->where('id', $id)->get()->toArray();

        $rating = Review::where('product_id', $id)->select('rating')->sum('rating');
        $totalReview = Review::where('product_id', $id)->select('rating')->count();
        if ($totalReview > 0) {
            $totalRating = $rating / $totalReview;
        } else {
            $totalRating = 0;
        }

        $productReview = Review::where('product_id', $id)->get()->toArray();

        return view('admin.products.reviews_details')->with(compact('totalRating', 'totalReview', 'products', 'productReview'));
    }

    // stats
    public function stats()
    {
        Session::put('page', 'stats');
        return view('admin.products.admin_stats');
    }

    // Geofence Offers
    public function geofenceoffer()
    {
        Session::put('page', 'offers');
        $coupons = Coupon::orderBy('id', 'Desc')->get()->toArray();
        // echo "<pre>";
        // print_r($coupons);
        // die;

        return view('admin.admin_geofenceoffer')->with(compact('coupons'));
    }
}
