<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use App\Models\Region;
use App\Models\Township;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TownshipsController extends Controller
{
    public function index()
    {
        // http://127.0.0.1:8000/townships?filtername=mm
        // dd(request("filtername")); // mm

        $townships = Township::where(function($query){
            if($getname = request("filtername")){
                $query->where("name","LIKE","%".$getname."%");
            }
        })->get();
        // dd($townships);

        $countries = Country::orderBy("name")->where("status_id",3)->get();
        $cities = City::orderBy("name")->where("status_id",3)->get();
        $regions = Region::orderBy("name")->where("status_id",3)->get();
        $statuses = Status::whereIn("id",[3,4])->get();

        return view("townships.index",compact("townships","countries","cities","regions","statuses"));
    }
    // request() - get the request form value

    public function store(Request $request)
    {
        $this->validate($request,[
            "country_id"=>"required",
            "region_id"=>"required",
            "city_id"=>"required",
            "name" => "required|unique:townships,name",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $township = new Township();
       $township->name = $request["name"];
       $township->slug = Str::slug($request["name"]);
       $township->country_id = $request["country_id"];
       $township->region_id = $request["region_id"];
       $township->city_id = $request["city_id"];
       $township->status_id = $request["status_id"];
       $township->user_id = $user_id;

       $township->save();
       return redirect(route("townships.index"));
    }


    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "editcountry_id"=>"required",
            "editregion_id"=>"required",
            "editcity_id"=>"required",
            "editname" => "required|unique:townships,name,".$id,
        ]);

       $user = Auth::user();
       $user_id = $user['id'];

       $township = Township::findOrFail($id);
       $township->name = $request["editname"];
       $township->slug = Str::slug($request["editname"]);
       $township->country_id = $request["editcountry_id"];
       $township->region_id = $request["editregion_id"];
       $township->city_id = $request["editcity_id"];
       $township->status_id = $request["editstatus_id"];
       $township->user_id = $user_id;

       $township->save();
       return redirect(route("townships.index"));
    }


    public function destroy(string $id)
    {
        $township = Township::findOrFail($id);
        $township->delete();
        return redirect()->back();
    }

    public function typestatus(Request $request){
        $township = Township::findOrFail($request["id"]);
        $township->status_id = $request["status_id"];
        $township->save();
    
        return response()->json(["success"=>"Status Change Successfully"]);
    }

    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            Township::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

}
