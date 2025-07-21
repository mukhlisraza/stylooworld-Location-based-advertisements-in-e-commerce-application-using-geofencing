<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use Illuminate\Support\Facades\Auth;
use Session;

class BrandController extends Controller
{
    //
    public function brands()
    {
        Session::put('page', 'brands');
        $brands = Brand::get(); //get all the brands there

        return view('admin.brands.brands')->with(compact('brands')); //use json data b/c not to much data
    }

    public function updateBrandStatus(Request $request)
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
            Brand::where('id', $data['brand_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'brand_id' => $data['brand_id']]);
        }
    }

    public  function addEditBrand(Request $request, $id = null)
    {
        if ($id == "") {
            $title = 'Add Brand';
            $brand = new Brand;
            $message = "Brand Has Been Added Successfully!";
        } else {
            $title = 'Edit Brand';
            $brand = Brand::find($id);
            $message = "Brand Has Been Updated Successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            //Brand Validations
            $rules = [
                'brand_name' => 'required|min:3|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'brand_name.required' => 'Brand name is required',
                'brand_name.min' => 'Brand name is required',
                'brand_name.regex' => 'Valid brand name is required, contain only characters',
            ];
            $this->validate($request, $rules, $customMessage);

            //Checking Brand Duplications
            $brandExists = Brand::where('name', '=', $data['brand_name'])->first();
            if ($brandExists === null) {
                //If brand not exits

                $brand->name = $data['brand_name'];
                $brand->status = 1;
                $brand->save();
                session::flash('success_message', $message);
                return redirect('admin/brands');
            } else {
                //If brand Exits
                $message = "Brand Already Exit. Please Add Another Brand";
                session::flash('error_message', $message);
                return redirect()->back();
            }
        }

        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand', 'message'));
    }

    /********************************* Delete Attributes ******************************/
    public function deleteBrand($id)
    {
        // Delete Brand
        Brand::where('id', $id)->delete();
        $message = 'Brand has been deleted successfully!';
        session::flash('success_message', $message);
        return redirect()->back();
    }
}
