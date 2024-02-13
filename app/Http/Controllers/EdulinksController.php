<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Edulink;
use App\Models\Post;
use App\Models\Stage;
use App\Models\Status;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EdulinksController extends Controller
{
    public function index()
    {
        // $data["edulinks"] = Edulink::orderBy("updated_at","desc")->paginate(5);
        
        // Method 1
        // $data["edulinks"] = Edulink::where(function($query){
        //     if($getfilter = request("filter")){
        //         $query->where("post_id",$getfilter);
        //     } 
        //     if($getsearch = request("search")){
        //         // $query->where("classdate","LIKE","%".$getsearch."%");
        //         $query->where("classdate","LIKE","%${getsearch}%");
        //     }
        // })->zaclassdate()->paginate(5);
        
        // Method 2 by Local Scope
        // \DB::enableQueryLog();
        // $data["edulinks"] = Edulink::all();
        // dd( \DB::getQueryLog());

        // \DB::enableQueryLog();
        $data["edulinks"] = Edulink::filter()->zaclassdate()->paginate(5);
        // dd( \DB::getQueryLog());
        
        
        // \DB::enableQueryLog();
        $data["posts"] = \DB::table("posts")->where("attshow",3)->orderBy("title","asc")->pluck('title',"id");
        // dd( \DB::getQueryLog());
        $data["filterposts"] = Post::whereIn("attshow",[3])->orderBy("title","asc")->pluck('title',"id")->prepend("Choose Class","");
        return view("edulinks.index",$data);
    }

    public function create()
    {    
         //$statuses = Status::all(); // get all statuses
         $statuses = Status::whereIn("id",[3,4])->get();
         return view("edulinks.create",compact("statuses"));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           "classdate"=>"required|date",
           "post_id"=>'required',
           "url"=>"required"
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $edulink = new Edulink();
       $edulink->classdate = $request["classdate"];
       $edulink->post_id = $request["post_id"];
       $edulink->url = $request["url"];
       $edulink->user_id = $user_id;

       $edulink->save();
       return redirect()->route("edulinks.index");
    }

    public function show(string $id)
    {
        $edulink = Edulink::findOrFail($id);
        return view("edulinks.show",["edulink"=>$edulink]);
    }


    public function edit(string $id)
    {
        $edulink = Edulink::findOrFail($id);
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("edulinks.edit")->with("edulink",$edulink)->with("statuses",$statuses);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "name" => ["required","max:50","unique:edulinks,name,".$id],
            "image" => ["image","mimes:jpg,jpeg,png","max:1024"],
            "status_id" => ["required","in:3,4"],
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $edulink = Edulink::findOrFail($id);
        $edulink->name = $request["name"];
        $edulink->slug = Str::slug($request["name"]);
        $edulink->status_id = $request["status_id"];
        $edulink->user_id = $user_id;

        $edulink->save();
        return redirect(route("edulinks.index"));
    }


    public function destroy(string $id)
    {
        $edulink = Edulink::findOrFail($id);
        
        // Remove Old Image
        $path = $edulink->image;
        if(File::exists($path)){
            File::delete($path);
        }
        
        $edulink->delete();
        return redirect()->back();
    }
}
