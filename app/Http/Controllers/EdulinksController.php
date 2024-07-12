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
        // $data["edulinks"] = Edulink::filter()->zaclassdate()->paginate(5);
        // dd( \DB::getQueryLog());

        // \DB::enableQueryLog();
        $data["edulinks"] = Edulink::filteronly()->searchonly()->zaclassdate()->paginate(5);
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
        //    return redirect()->route("edulinks.index");
        // return redirect()->route("edulinks.index")->with("success","New Link Created");

        session()->flash("success","New Link Created!!");
        return redirect()->route("edulinks.index");
    }

    public function show(string $id)
    {
        $edulink = Edulink::findOrFail($id);
        return view("edulinks.show",["edulink"=>$edulink]);
    }



    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "editclassdate"=>"required|date",
            "editpost_id"=>'required',
            "editurl"=>"required"
         ]);

        $user = Auth::user();
        $user_id = $user->id;

        $edulink = Edulink::findOrFail($id);
        $edulink->classdate = $request["editclassdate"];
        $edulink->post_id = Str::slug($request["editpost_id"]);
        $edulink->url = $request["editurl"];
        $edulink->user_id = $user_id;

        $edulink->save();
        // return redirect(route("edulinks.index"));
        // return redirect()->route("edulinks.index")->with("success","Update Successfully");
         
        session()->flash("success","Update Successfully!!");
        return redirect()->route("edulinks.index");
    }


    public function destroy(string $id)
    {
        $edulink = Edulink::findOrFail($id);
        $edulink->delete();

        session()->flash("success","Delete Successfully!!");
        return redirect()->back();
    }

    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            Edulink::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

    public function download($id){
        $edulink = Edulink::findOrFail($id);
        $edulink->increment("counter");
        return redirect($edulink->url);
    }
}
