<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class AdminController extends Controller
{
    public function courseShowApi(Request $request){
        $id = $request->id;
        $flag = $request->flag;
        if($request->flag == 'courseDescrip' && $id){
            $data=DB::select("SELECT c.id,c.title,c.description,c.image_label,c.image_desc  FROM course as c WHERE c.id='$id'");
            return response()->json([
                'status'=>http_response_code(200),
                'data'=>$data,
            ]);
        }
        else{
            $data=DB::select('SELECT c.id,c.title,c.description,c.image_label,c.image_desc  FROM course as c');            
            return response()->json([
                'status'=>http_response_code(200),
                'data'=>$data,
            ]);
        }
    }
    public function showCourse(Request $request){
        $id = $request->id;
        if($request->flag == 'edit' && $id){
            $data=DB::select("SELECT c.id,c.title,c.description,c.image_label,c.image_desc  FROM course as c WHERE c.id='$id'");
            return view('admin.course')->with(['editPage'=>$data]);
        }
        elseif($request->flag == 'delete' && $id){
            DB::table('course')->delete($id);
            return redirect('/admin/course')->with('message','Course Deleted Successfully');
        }
        else{
            $data=DB::select('SELECT c.id,c.title,c.description,c.image_label,c.image_desc  FROM course as c');
            return view('admin.course')->with(['data'=>$data]);
        }
    }
    public function addCourse(Request $request){
        $filePathDesc=$course_title=$course_desc=$filePathLabel='';
        $course_title = $request->course_title;
        $course_desc = $request->course_desc;
        // Validate the uploaded file
        $request->validate([
            'course_label_image' => 'file|mimes:jpg,png,pdf|max:2048',
            'course_desc_image' => 'file|mimes:jpg,png,pdf|max:2048',
            'course_title'=>'required',
        ]);

        // Check if the file is valid
        if($request->file('course_label_image')){
            if ($request->file('course_label_image')->isValid()) {
                // Store the file in the 'uploads' directory on the 'public' disk   storage/app/public/images         
                $filePathLabel = $request->file('course_label_image')->store('images', 'public');
            }else{
                return back()->with('error', 'File upload failed');
            }
        }else{
            if($request->course_label_image_already){
                $filePathLabel = $request->course_label_image_already;
            }
        }
        if($request->file('course_desc_image')){
            if ($request->file('course_desc_image')->isValid()) {
                $filePathDesc = $request->file('course_desc_image')->store('images', 'public');
            }else{
                return back()->with('error', 'File upload failed');
            }
        }else{
            if($request->course_desc_image_already){
                $filePathDesc = $request->course_desc_image_already;
            }
        }
        if($request->id && $request->flag == 'edit'){
            $sql = DB::table('course')->where('id', $request->id)
            ->update(
                    [
                        'title' => $course_title,
                        'description' => $course_desc,
                        'image_label' => $filePathLabel,
                        'image_desc' => $filePathDesc,
                    ]
                ); 
            $succeMSg = 'Course Updated Successfully';
        }else{
            $sql = DB::table('course')->insert(
                ['title' => $course_title,
                'description' => $course_desc,
                'image_label' => $filePathLabel,
                'image_desc' => $filePathDesc,
                ]
            );
            $succeMSg = 'Course Added Successfully';
        }
        if($sql){
            return redirect('/admin/course')->with('message',$succeMSg);

        }else{
            return back()->with('error', 'Some issue with Course');
        }
    }
}
