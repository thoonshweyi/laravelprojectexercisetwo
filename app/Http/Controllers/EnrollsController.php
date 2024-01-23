<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enroll;
use App\Models\Stage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EnrollsController extends Controller
{
    public function index()
    {
        $enrolls = Enroll::all();
        return view("enrolls.index",compact("enrolls"));
    }

    public function create()
    {    
         //$statuses = Status::all(); // get all statuses
         $statuses = Status::whereIn("id",[3,4])->get();
         return view("enrolls.create",compact("statuses"));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "image" => "image|mimes:jpg,jpeg,png|max:1024",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $enroll = new Enroll();
       $enroll->post_id = $request["post_id"];
       $enroll->remark = $request["remark"];
       $enroll->user_id = $user_id;

        // Single Image Upload
        if(file_exists($request["image"])){
            $file = $request["image"];
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$enroll['id'].$fname;
            // $file->move(public_path("enrolls/img"),$imagenewname);
            $file->move(public_path("assets/img/enrolls"),$imagenewname);
            
            $filepath = "assets/img/enrolls/".$imagenewname;
            $enroll->image = $filepath;
        }    

       $enroll->save();
       return redirect()->back();
    }

    public function show(string $id)
    {
        $enroll = Enroll::findOrFail($id);
        return view("enrolls.show",["enroll"=>$enroll]);
    }


    public function edit(string $id)
    {
        $enroll = Enroll::findOrFail($id);
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("enrolls.edit")->with("enroll",$enroll)->with("statuses",$statuses);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "name" => ["required","max:50","unique:enrolls,name,".$id],
            "image" => ["image","mimes:jpg,jpeg,png","max:1024"],
            "status_id" => ["required","in:3,4"],
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $enroll = Enroll::findOrFail($id);
        $enroll->name = $request["name"];
        $enroll->slug = Str::slug($request["name"]);
        $enroll->status_id = $request["status_id"];
        $enroll->user_id = $user_id;

        // Remove Old Image
        if($request->hasFile("image")){
            $path = $enroll->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Upload
        if($request->hasFile("image")){
            $file = $request->file("image");
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$enroll['id'].$fname;
            $file->move(public_path("assets/img/enrolls"),$imagenewname);
            
            $filepath = "assets/img/enrolls/".$imagenewname;
            $enroll->image = $filepath;
        }    

        $enroll->save();
        return redirect(route("enrolls.index"));
    }


    public function destroy(string $id)
    {
        $enroll = Enroll::findOrFail($id);
        
        // Remove Old Image
        $path = $enroll->image;
        if(File::exists($path)){
            File::delete($path);
        }
        
        $enroll->delete();
        return redirect()->back();
    }
}
