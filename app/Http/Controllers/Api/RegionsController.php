<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\RegionsResource;
use App\Models\Region;


class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
     {
            // $this->authorize('view',Region::class);
         $regions = Region::paginate(30);
         return  RegionsResource::collection($regions);
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
 
        $region = new Region();
            // $this->authorize('create',$region);
        $region->name = $request["name"];
        $region->slug = Str::slug($request["name"]);
        $region->country_id = $request["country_id"];
        $region->status_id = $request["status_id"];
        $region->user_id = $request["user_id"];
 
        $region->save();
 
        return new RegionsResource($region);
         
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
 
        $region = Region::findOrFail($id);
            // $this->authorize('edit',$region);
        $region->name = $request["editname"];
        $region->slug = Str::slug($request["editname"]);
        $region->country_id = $request["editcountry_id"];
        $region->status_id = $request["editstatus_id"];
        $region->user_id = $request["user_id"];
 
        $region->save();
 
        return new RegionsResource($region);
         
     }
 
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy(string $id)
     {
         $region = Region::findOrFail($id);
            // $this->authorize('delete',$region);
         $region->delete();
         return new RegionsResource($region);
     }
 
     public function typestatus(Request $request){
         $region = Region::findOrFail($request["id"]);
         $region->status_id = $request["status_id"];
         $region->save();
 
         return new RegionsResource($region);
     }

    public function filterbycountryid($filter){
        // return Region::where("country_id",$filter)->where('status_id',3)->get();
        return RegionsResource::collection(Region::where("country_id",$filter)->where('status_id',3)->orderBy("name","asc")->get());
    }
}
