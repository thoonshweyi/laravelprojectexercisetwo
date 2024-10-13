<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Religion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReligionsController extends Controller
{
    public function index()
    {
        $religions = Religion::where(function($query){
            if($getname = request("filtername")){
                $query->where("name","LIKE","%".$getname."%");
            }
        })->get();
        // dd($countries);

        $statuses = Status::whereIn("id",[3,4])->get();

        return view("religions.index",compact("religions","statuses"));
    }


    public function create()
    {
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("religions.create",compact("statuses"));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|max:50|unique:religions",
            "status_id" => "required|in:3,4",
        ],[
            "name.required"=>"Religion Name is required"
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $religion = new Religion();
       $religion->name = $request["name"];
       $religion->slug = Str::slug($request["name"]);
       $religion->status_id = $request["status_id"];
       $religion->user_id = $user_id;
       $religion->save();
       return redirect(route("religions.index"));
    }
    
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "name" => ["required","max:50","unique:religions,name,".$id],
            "status_id" => ["required","in:3,4"],
        ]);

        $user = Auth::user();
        $user_id = $user["id"];

        $religion = Religion::findOrFail($id);
        $religion->name = $request["name"];
        $religion->slug = Str::slug($request["name"]);
        $religion->status_id = $request["status_id"];
        $religion->user_id = $user_id;
        $religion->save();
        return redirect(route("religions.index"));
    }


    public function destroy(string $id)
    {
        $religion = Religion::findOrFail($id);
        $religion->delete();
        return redirect()->back();
    }

    public function typestatus(Request $request){
        $religion = Religion::findOrFail($request["id"]);
        $religion->status_id = $request["status_id"];
        $religion->save();
    
        return response()->json(["success"=>"Status Change Successfully"]);
    }

    
    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            Religion::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }
}
