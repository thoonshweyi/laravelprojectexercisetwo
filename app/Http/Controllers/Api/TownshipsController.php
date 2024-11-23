<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\TownshipsResource;
use App\Models\Township;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class TownshipsController extends Controller
{
    public function index()
     {
         $townships = Township::paginate(30);
         return  TownshipsResource::collection($townships);
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         $this->validate($request,[
             "name" => "required|unique:townships,name",
             "country_id" => "required",
             "region_id" => "required",
             "status_id" => "required",
             "user_id" => "required"
         ]);
 
        $township = new Township();
        $township->name = $request["name"];
        $township->slug = Str::slug($request["name"]);
        $township->country_id = $request["country_id"];
        $township->region_id = $request["region_id"];
        $township->city_id = $request["city_id"];
        $township->status_id = $request["status_id"];
        $township->user_id = $request["user_id"];
 
        $township->save();
 
        return new TownshipsResource($township);
         
     }
 
     /**
      * Display the specified resource.
      */
     public function show(string $id)
     {
         //
     }
 
     public function update(Request $request, string $id)
     {
         $this->validate($request,[
             "editname" => "required|unique:townships,name,".$id,
             "editcountry_id" => "required",
             "editregion_id" => "required",
             "editcity_id" => "required",
             "editstatus_id" => "required",
             "user_id" => "required"
         ]);
 
        $township = Township::findOrFail($id);
        $township->name = $request["editname"];
        $township->slug = Str::slug($request["editname"]);
        $township->country_id = $request["editcountry_id"];
        $township->region_id = $request["editregion_id"];
        $township->city_id = $request["editcity_id"];
        $township->status_id = $request["editstatus_id"];
        $township->user_id = $request["user_id"];
 
        $township->save();
 
        return new TownshipsResource($township);
         
     }
 
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy(string $id)
     {
         $township = Township::findOrFail($id);
         $township->delete();
         return new TownshipsResource($township);
     }
 
     public function typestatus(Request $request){
         $township = Township::findOrFail($request["id"]);
         $township->status_id = $request["status_id"];
         $township->save();
 
         return new TownshipsResource($township);
     }

     public function filterbycityid($filter){
        // return Township::where("country_id",$filter)->where('status_id',3)->get();
        return TownshipsResource::collection(Township::where("city_id",$filter)->where('status_id',3)->get());
    }
}
