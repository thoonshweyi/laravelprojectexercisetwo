<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\CitiesResource;
use App\Models\City;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CitiesController extends Controller
{
     public function index()
     {
            // $this->authorize('view',City::class);
         $cities = City::paginate(30);
         return  CitiesResource::collection($cities);
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         $this->validate($request,[
             "name" => "required|unique:cities,name",
             "country_id" => "required",
             "region_id" => "required",
             "status_id" => "required",
             "user_id" => "required"
         ]);
 
        $city = new City();
            // $this->authorize('create',$city);
        $city->name = $request["name"];
        $city->slug = Str::slug($request["name"]);
        $city->country_id = $request["country_id"];
        $city->region_id = $request["region_id"];
        $city->status_id = $request["status_id"];
        $city->user_id = $request["user_id"];
 
        $city->save();
 
        return new CitiesResource($city);
         
     }
 
     /**
      * Display the specified resource.
      */
     public function show(string $id)
     {
         //
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, string $id)
     {
         $this->validate($request,[
             "editname" => "required|unique:cities,name,".$id,
             "editcountry_id" => "required",
             "editregion_id" => "required",
             "editstatus_id" => "required",
             "user_id" => "required"
         ]);
 
        $city = City::findOrFail($id);
            // $this->authorize('edit',$city);
        $city->name = $request["editname"];
        $city->slug = Str::slug($request["editname"]);
        $city->country_id = $request["editcountry_id"];
        $city->region_id = $request["editregion_id"];
        $city->status_id = $request["editstatus_id"];
        $city->user_id = $request["user_id"];
 
        $city->save();
 
        return new CitiesResource($city);
         
     }
 
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy(string $id)
     {
         $city = City::findOrFail($id);
            // $this->authorize('delete',$city);
         $city->delete();
         return new CitiesResource($city);
     }
 
     public function typestatus(Request $request){
         $city = City::findOrFail($request["id"]);
         $city->status_id = $request["status_id"];
         $city->save();
 
         return new CitiesResource($city);
     }

     public function filterbyregionid($filter){
        // return City::where("country_id",$filter)->where('status_id',3)->get();
        return CitiesResource::collection(City::where("region_id",$filter)->where('status_id',3)->get());
    }
}
