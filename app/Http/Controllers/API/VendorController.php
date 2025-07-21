<?php

namespace App\Http\Controllers\API;

use App\Admin;
use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrdersLog;
use App\OrdersProduct;
use App\OrderStatus;
use App\Product;
use App\ProductColor;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;

class VendorController extends Controller
{
    // calidate login

    public function login(Request $request)
    {
        $mobile = $request->mobile;
        $password = $request->password;

        // echo "<pre>";
        // print_r($mobile);
        // die;
        $user = Admin::where(['mobile' => $mobile])->first();
        // echo "<pre>";
        // print_r($user);
        // die;
        if (Hash::check($password, $user->password)) {
            return array(['id' => $user->id, 'name' => $user->name, 'mobile' => $user->mobile, 'business_name' => $user->business_name, 'business_address' => $user->business_address, 'image' => $user->image, 'account_status' => $user->status]);
        } else {
            echo "0";
        }


        // if (empty($user)) {
        //     $message = "Account not exists!";
        //     return response()->json(['status' => false, 'message' => $message], 402);
        // } else {
        //     if (Hash::check($password, $user->password)) {
        //         $message = "Welcome to dashboard";
        //         $userDetails = Admin::where('mobile', $request->mobile)->first()->toArray();
        //         return response()->json(['status' => true, 'message' => $message, 'Vendor Details' => $userDetails], 200);
        //     } else {
        //         $message = "Invalid Username or Password";

        //         return response()->json(['status' => false, 'message' => $message], 402);
        //     }
        // }
    }

    // All Products Listing
    public function allProducts($vendor_id)
    {

        $products = Product::with(['Category' => function ($query) {
            //subqueries
            $query->select('id', 'category_name');
        }, 'Section' => function ($query) {
            $query->select('id', 'name');
        }])->where('vendor_id', $vendor_id)->orderBy('id', 'Desc')->get();

        $message = "All products";
        return response()->json(['status' => true, 'message' => $message, 'products' => $products], 200);
    }

    // Listing Sections
    public function allSections()
    {
        $sections = Section::where('status', 1)->get();
        $message = "All Sections";
        return response()->json(['status' => true, 'message' => $message, 'sections' => $sections], 200);
    }

    // Listing Brands
    public function allBrands()
    {
        $brands = Brand::where('status', 1)->get();
        $message = "All Brands";
        return response()->json(['status' => true, 'message' => $message, 'brands' => $brands], 200);
    }

    // All parent Categories
    public function allParentCategories($section_id)
    {

        $categories = Category::where('section_id', $section_id)
            ->where('parent_id', 0)
            ->get();
        $message = "All parent category!";
        return response()->json(['status' => true, 'message' => $message, 'category' => $categories], 200);
    }

    // All sub Categories
    public function allSubCategories($category_id)
    {

        $categories = Category::where('parent_id', $category_id)->get();
        $message = "All sub category!";
        return response()->json(['status' => true, 'message' => $message, 'subcategory' => $categories], 200);
    }

    // Add Products
    public function AddProducts(Request $request, $vendor_id)
    {

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
                'product_weight' => 'required',
                'category_image' => 'image',

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
            ];


            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 402);
            }


            $product = new Product;

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

                return response()->json(['status' => false, 'message' => $message], 402);
            }

            //Upload Product Images 
            if (!empty($request->main_image)) {
                $image_tmp = base64_decode($request->main_image);

                //upload image after resize
                //Get Image Extension
                $image_name = time() . ".jpg"; //get the image name
                $large_image_path = 'images/product_images/large/' . $image_name;
                $medium_image_path = 'images/product_images/medium/' . $image_name;
                $small_image_path = 'images/product_images/small/' . $image_name;
                //Upload Image
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->save($medium_image_path);
                Image::make($image_tmp)->save($small_image_path);
                $product->main_image = $image_name; // save name in database table products column main_image


            }
            //End upload images

            // //Upload Product Video
            // if (!empty($request->product_video)) {
            //     $video_tmp = base64_decode($request->product_video);

            //     //Get video Extension
            //     $video_name = time() . ".mp4";
            //     $video_path = 'videos/product_videos';
            //     $video_tmp->move($video_path, $video_name);
            //     $product->product_video = $video_name;
            // }
            //End upload Video

            $product->vendor_id = $vendor_id;
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->product_name = $data['product_name'];
            $product->product_actual_price = $data['product_actual_price'];
            $product->product_price = $data['product_price'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];

            $product->meta_keywords = $data['meta_keywords'];

            $product->is_featured = $is_featured;
            $product->status = 1; //add status by default active
            $product->save();

            $message = "Product is successfully Added!";

            return response()->json(['status' => true, 'message' => $message], 200);
        }
    }

    public  function EditProducts(Request $request, $product_id)
    {
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
                'product_weight' => 'required',
                'category_image' => 'image',

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
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 402);
            }

            $product = new Product;

            if (!empty($request->main_image)) {
                $image_tmp = base64_decode($request->main_image);

                //upload image after resize
                //Get Image Extension
                $image_name = time() . ".jpg"; //get the image name
                $large_image_path = 'images/product_images/large/' . $image_name;
                $medium_image_path = 'images/product_images/medium/' . $image_name;
                $small_image_path = 'images/product_images/small/' . $image_name;
                //Upload Image
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->save($medium_image_path);
                Image::make($image_tmp)->save($small_image_path);
                $product->main_image = $image_name; // save name in database table products column main_image


            }

            Product::where(['id' => $product_id])->update([
                'vendor_id' => $data['vendor_id'],
                'section_id' => $data['section_id'],
                'category_id' => $data['category_id'],
                'brand_id' => $data['brand_id'],
                'product_name' => $data['product_name'],
                'product_actual_price' => $data['product_actual_price'],
                'product_price' => $data['product_price'],
                'product_weight' => $data['product_weight'],
                'description' => $data['description'],
                'wash_care' => $data['wash_care'],
                'meta_keywords' => $data['meta_keywords'],
                'is_featured' => $data['is_featured'],
            ]);


            $message = "Product is successfully Edited!";

            return response()->json(['status' => true, 'message' => $message], 200);
        }
    }

    public function AddProductAttributes(Request $request, $product_id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;


            if (!empty($data)) {


                //size already exits validation
                $attrCountSize = ProductsAttribute::where(['product_id' => $product_id, 'size' => $data['size']])->count();
                if ($attrCountSize > 0) {
                    $message = "Size Already Exit. Please Add Another Size";
                    return response()->json(['status' => false, 'message' => $message], 402);
                }

                if ($data['price'] <= 0) {
                    $message = "Price should be greater than 0";
                    return response()->json(['status' => false, 'message' => $message], 402);
                }
                if ($data['stock'] < 0) {
                    $message = "Stock should be equal or greater than 0";
                    return response()->json(['status' => false, 'message' => $message], 402);
                }

                $attribute = new ProductsAttribute;
                $attribute->product_id = $product_id;
                // $attribute->sku = $value;
                $attribute->size = $data['size'];
                $attribute->price = $data['price'];
                $attribute->stock = $data['stock'];
                $attribute->status = 1;
                $attribute->save();
            }

            $success_message = "Product attributes has been added successfully!";
            return response()->json(['status' => true, 'message' => $success_message], 200);
        }
    }

    public function AddProductAttributesColors(Request $request, $product_id, $attribute_id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            foreach ($data['size'] as $key => $value) {
                if (!empty($value)) {

                    //size already exits validation
                    $attrCountSize = ProductColor::where(['product_id' => $product_id, 'color' => $data['size'][$key]])->count();
                    if ($attrCountSize > 0) {
                        $message = "Color already exit. Please add another color";
                        return response()->json(['status' => false, 'message' => $message], 402);
                    }


                    if ($data['stock'][$key] < 0) {
                        $message = "Stock should be equal or greater than 0";
                        return response()->json(['status' => false, 'message' => $message], 402);
                    }

                    $attribute = new ProductColor;
                    $attribute->product_id = $data['product_id'];
                    $attribute->size_id = $attribute_id;
                    $attribute->size = $data['product_attribute_size'];
                    // $attribute->sku = $value;
                    $attribute->color = $value;
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $message = "Product colors has been added successfully!";
            return response()->json(['status' => false, 'message' => $message], 200);
        }
    }

    public function viewAttributesColor($attribute_id)
    {
        $productColor = ProductColor::where('size_id', $attribute_id)->get();
        return response()->json(['status' => true, "attribute id" => $attribute_id, 'attributes colors' => $productColor], 200);
    }

    public function AddProductImages(Request $request, $product_id)
    {
        if ($request->isMethod('post')) {
            // $data = $request->all();

            $productImage = new ProductsImage;

            //Upload Product Images 
            if (!empty($request->image)) {
                $image_tmp = base64_decode($request->image);

                //upload image after resize
                //Get Image Extension
                $image_name = time() . ".jpg"; //get the image name
                $large_image_path = 'images/product_images/large/' . $image_name;
                $medium_image_path = 'images/product_images/medium/' . $image_name;
                $small_image_path = 'images/product_images/small/' . $image_name;
                //Upload Image
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->save($medium_image_path);
                Image::make($image_tmp)->save($small_image_path);
                $productImage->image = $image_name; // save name in database table products column main_image

                $productImage->product_id = $product_id;
                $productImage->status = 1;
                $productImage->save();
            }
            //End upload images
            $success_message = "Product image added successfully!";
            return response()->json(['status' => true, 'message' => $success_message], 200);
        }
    }

    public function getProductImages($product_id)
    {
        $productdata = ProductsImage::where('product_id', $product_id)->get();
        return response()->json(['status' => true, 'all images' => $productdata], 200);
    }

    public function product_id($product_id)
    {
        $getAttributes = ProductsAttribute::where('product_id', $product_id)->get();
        return response()->json(['status' => true, 'product id' => $product_id, 'product attributes' => $getAttributes], 200);
    }


    public function deleteProducts($id)
    {
        Product::where('id', $id)->delete();
        $message = "Product has been successfully deleted!";
        return response()->json(['status' => true, 'message' => $message,], 200);
    }

    // View Products Details
    public function viewProducts($id)
    {
        $viewProduct = Product::where('id', $id)->get()->toArray();

        return response()->json(['status' => true, 'product details' => $viewProduct,], 200);
    }

    // View Orders
    public function viewOrders($vendor_id)
    {
        // Session::put('page', 'manageorders');
        // $orders = Order::with(['orders_products' => function ($query) {
        //     $query->where('vendor_id', $vendor_id);
        // }])->orderBy('id', 'Desc')->get()->toArray();

        // $ordersAdmin = Order::with('orders_products')->orderBy('id', 'Desc')->get()->toArray();

        $order = Order::where('vendor_id', $vendor_id)
            ->orderBy('id', 'Desc')
            ->get()
            ->toArray();

        return response()->json(['status' => true, 'All Orders' => $order], 200);
    }

    // View the details
    public function orderDetails($id, $vendor_id)
    {
        $order = OrdersProduct::where('order_id', $id)->where('vendor_id', $vendor_id)->orderBy('id', 'Desc')->get()->toArray();

        $orderLog = OrdersLog::where('order_id', $id)->get()->toArray();

        return response()->json(['status' => true, 'order detail' => $order, 'order log' => $orderLog], 200);
    }

    public function addEditProductStatus(Request $request, $product_id)
    {
        if ($request->isMethod('post')) {

            if ($request->status == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $product_id)->update(['status' => $status]);

            return response()->json(['status' => true, 'message' => 'Product is successfuly updated'], 200);
        }
    }

    public function addEditProductAttributeStatus(Request $request, $product_id)
    {
        if ($request->isMethod('post')) {

            if ($request->status == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('product_id', $product_id)->where('size', $request->size)->update(['status' => $status]);
            return response()->json(['status' => true, 'message' => 'Product attribute status is successfuly updated'], 200);
        }
    }

    public function addEditProductImageStatus(Request $request, $product_id)
    {
        if ($request->isMethod('post')) {

            if ($request->status == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('product_id', $product_id)->where('image', $request->image)->update(['status' => $status]);
            return response()->json(['status' => true, 'message' => 'Product image status is successfuly updated'], 200);
        }
    }
}
