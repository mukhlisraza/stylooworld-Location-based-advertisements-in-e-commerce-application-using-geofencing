<?php

namespace App\Http\Controllers\Admin;

use App\Section;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class SectionController extends Controller
{
    //
    public function sections()
    {

        $sections = Section::get(); //All the section model data fetch and send into the blade file whatever it is disable or enable 
        Session::put('page', 'sections');
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request)
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
            Section::where('id', $data['section_id'])->update(['status' => $status]); // save the new status
            return response()->json(['status' => $status, 'section_id' => $data['section_id']]);
        }
    }

    public function getSection()
    {
        return view('admin.sections.add_section');
    }

    public function addSection(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $section = new Section;
            $section->name = $data['section_name'];
            $section->status = 1;
            $section->save();

            $message = "Section Add Successfuly";
            Session::flash('success_message', $message);
            return redirect('admin/sections');
        }
    }

    public function getEditSection($id)
    {
        $sectionData = Section::find($id);
        return view('admin.sections.edit_section')->with(compact('sectionData'));
    }

    public function editSection(Request $request, $id)
    {
        // $section = Section::find($id);
        // echo "<pre>";
        // print_r($section);
        // die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            Section::where('id', $data['sectionId'])->update(['name' => $data['section_name']]);
            $message = "Section Edit Successfuly";
            Session::flash('success_message', $message);
            return redirect('admin/sections');
        }
    }
}
