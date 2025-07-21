<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Image;

class BannersController extends Controller
{
    // Manage Slider
    public function manageBanners()
    {
        Session::put('page', 'Banner');

        $banner = Banner::get();
        // dd($banner);
        // die;
        return view('admin.banners.admin_manage_banner')->with(compact('banner'));
    }


    //Add Edit Banners
    public function addEditBanner(Request $request, $id = null)
    {

        if ($id == "") {
            $banner = new Banner;
            $title = "Add Banner";
            $message = 'Banner Added Successfully!';
        } else {
            $banner = Banner::find($id);
            $title = "Edit Banner";
            $message = 'Banner Edit Successfully!';
        }
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'title' => 'required|min:3|regex:/^[\pL\s\-]+$/u|max:100',
                'description' => 'required|max:50|regex:/^[\pL\s\-]+$/u|max:200',
                'alt' => 'max:50',
                'image' => 'image',
                'link' => 'url',

            ];
            $customMessage = [
                'title.required' => 'Title is required',
                'title.regex' => 'Title Must have Character',
                'title.max' => 'Title have must 50 Character',
                'alt.max' => 'Alternative Text have must 50 Character',
                'description.required' => 'Description is required',
                'description.regex' => 'Description Must have Character',
                'description.max' => 'Description have must 50 Character',
                'image.image' => 'Valid image is required',
                'link.url' => 'Valid URL is required',
            ];
            $this->validate($request, $rules, $customMessage);

            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->description = $data['description'];
            $banner->alt = $data['alt'];
            $banner->status = 1;
            //Upload Product Images 
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    //upload image after resize
                    //Get Image Extension
                    $image_name = $image_tmp->getClientOriginalName(); //get the image name
                    $extension = $image_tmp->getClientOriginalExtension(); //get extention of the image
                    $imageName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                    $banner_image_path = 'images/banner_images/' . $imageName;

                    //Upload Image
                    Image::make($image_tmp)->resize(484, 400)->save($banner_image_path);
                    $banner->image = $imageName; // save name in database table products column main_image
                }
            }
            $banner->save();
            session::flash('success_message', $message);
            return redirect('admin/banner');
        }
        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner'));
    }


    public function updateBannerStatus(Request $request)
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
            Banner::where('id', $data['banners_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'banners_id' => $data['banners_id']]);
        }
    }

    public function deleteBanner($id)
    {
        // Delete Banner
        $bannerImage = Banner::where('id', $id)->first();
        $banner_image_path = 'images/banner_images/';

        if (file_exists($banner_image_path . $bannerImage->image)) {
            unlink($banner_image_path . $bannerImage->image);
        }
        Banner::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Banner has been deleted successfully!');
    }

    // Delete Banner images
    public function deleteBannerImage($id)
    {
        //get product images that we want to delete
        $bannerImage = Banner::select('image')->where('id', $id)->first();

        // get product images path
        $banner_image_path = 'images/banner_images/';

        // Delete product image from product_images folder if exist
        if (file_exists($banner_image_path . $bannerImage->image)) {
            unlink($banner_image_path . $bannerImage->image);
        }

        // Delete product image from product table
        Banner::where('id', $id)->update(['image' => '']);
        return redirect()->back()->with('success_message', 'Banner Image has been deleted successfully!');
    }
}
