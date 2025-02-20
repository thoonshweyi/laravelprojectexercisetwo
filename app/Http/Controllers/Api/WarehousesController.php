<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\WarehousesCollection;
use App\Http\Resources\WarehousesResource;
use App\Models\Warehouse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class WarehousesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $warehouses = Warehouse::all();
        // return new WarehousesCollection($warehouses);

        $warehouses = Warehouse::paginate(5);

        return $this->sendRespond(new WarehousesCollection($warehouses),"Warehouses retrived successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:warehouses,name",
            "status_id" => "required",
            "user_id" => "required"
        ]);
        

        if($validator->fails()){
            return $this->sendError("Validation Error",$validator->errors());
        }

       $warehouse = new Warehouse();
       $warehouse->name = $request["name"];
       $warehouse->slug = Str::slug($request["name"]);
       $warehouse->status_id = $request["status_id"];
       $warehouse->user_id = $request["user_id"];

       $warehouse->save();

       return $this->sendRespond(new WarehousesResource($warehouse),"Warehouses created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouse = Warehouse::findOrFail();
        if(is_null($warehouse)){
            return $this->sendError("Warehouse not found.");
        }
       return $this->sendRespond(new WarehousesResource($warehouse),"Warehouses retrived successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:warehouses,name".$id,
            "status_id" => "required",
            "user_id" => "required"
        ]);
        if($validator->fails()){
            return $this->sendError("Validation Error",$validator->errors());
        }

       $warehouse = Warehouse::findOrFail($id);
       $warehouse->name = $request["name"];
       $warehouse->slug = Str::slug($request["name"]);
       $warehouse->status_id = $request["status_id"];
       $warehouse->user_id = $request["user_id"];

       $warehouse->save();

       return $this->sendRespond(new WarehousesResource($warehouse),"Warehouses updated successfully");
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
        return $this->sendRespond(new WarehousesResource($warehouse),"Warehouses deleted successfully");

        
    }

    public function typestatus(Request $request){
        $warehouse = Warehouse::findOrFail($request["id"]);
        $warehouse->status_id = $request["status_id"];
        $warehouse->save();

        return $this->sendRespond(new WarehousesResource($warehouse),"Warehouses status changed.");

    }
}