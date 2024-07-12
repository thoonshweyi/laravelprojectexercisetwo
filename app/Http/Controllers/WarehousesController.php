<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class WarehousesController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("warehouses.index",compact("warehouses","statuses"));
    }

    public function create()
    {
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("warehouses.create",compact("statuses"));
    }

    public function edit(string $id){
        $warehouse = Warehouse::findOrFail($id);
        return response()->json($warehouse);
    }

    

    public function fetchalldatas()
    {
        try{
            $warehouses = Warehouse::all();
            return response()->json(["status"=>"scuccess","data"=>$warehouses]);
        }catch(Exception $e){
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
       
    }

    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            Warehouse::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }
}
