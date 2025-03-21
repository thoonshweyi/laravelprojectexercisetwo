<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\City;
use App\Models\Region;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
 

class RegionsController extends Controller
{
    public function index()
    {
        // http://127.0.0.1:8000/regions?filtername=mm
        // dd(request("filtername")); // mm
            $this->authorize('view',Region::class);
        $regions = Region::where(function($query){
            if($getname = request("filtername")){
                $query->where("name","LIKE","%".$getname."%");
            }
        })->get();
        // dd($regions);

        $countries = Country::orderBy("name")->where("status_id",3)->get();
        $statuses = Status::whereIn("id",[3,4])->get();

        return view("regions.index",compact("regions","countries","statuses"));
    }
    // request() - get the request form value

    public function store(Request $request)
    {
        $this->validate($request,[
            "country_id"=>"required",
            // "city_id"=>"required",
            "name" => "required|unique:regions,name",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $region = new Region();
            $this->authorize('create',$region);
       $region->name = $request["name"];
       $region->slug = Str::slug($request["name"]);
       $region->country_id = $request["country_id"];
    //    $region->city_id = $request["city_id"];
       $region->status_id = $request["status_id"];
       $region->user_id = $user_id;

       $region->save();
       return redirect(route("regions.index"));
    }


    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "editcountry_id"=>"required",
            // "editcity_id"=>"required",
            "editname" => "required|unique:regions,name,".$id,
        ]);

       $user = Auth::user();
       $user_id = $user['id'];

       $region = Region::findOrFail($id);
            $this->authorize('edit',$region);
       $region->name = $request["editname"];
       $region->slug = Str::slug($request["editname"]);
       $region->country_id = $request["editcountry_id"];
    //    $region->city_id = $request["editcity_id"];
       $region->status_id = $request["editstatus_id"];
       $region->user_id = $user_id;

       $region->save();
       return redirect(route("regions.index"));
    }


    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);
            $this->authorize('delete',$region);
        $region->delete();
        return redirect()->back();
    }

    public function typestatus(Request $request){
        $region = Region::findOrFail($request["id"]);
        $region->status_id = $request["status_id"];
        $region->save();
    
        return response()->json(["success"=>"Status Change Successfully"]);
    }

    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            Region::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

}
