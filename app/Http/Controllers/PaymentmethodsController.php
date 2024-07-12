<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\PaymentMethod;
use App\Models\Paymenttype;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentmethodsController extends Controller
{
    public function index()
    {
        $paymentmethods = Paymentmethod::all();
        $paymenttypes = Paymenttype::where("status_id",3)->get();
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("paymentmethods.index",compact("paymentmethods","paymenttypes","statuses"));
    }


    public function create()
    {
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("paymentmethods.create",compact("statuses"));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|max:50|unique:paymentmethods",
            "paymenttype_id" => "required",
            "status_id" => "required|in:3,4",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       try{
            $paymentmethod = new Paymentmethod();
            $paymentmethod->name = $request["name"];
            $paymentmethod->paymenttype_id = $request["paymenttype_id"];
            $paymentmethod->slug = Str::slug($request["name"]);
            $paymentmethod->status_id = $request["status_id"];
            $paymentmethod->user_id = $user_id;
            $paymentmethod->save();

            if($paymentmethod){
                return response()->json(["status"=>"success","data"=>$paymentmethod]);
            }
       }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
       }

       
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "name" => ["required","max:50","unique:paymentmethods,name,".$id],
            "paymenttype_id" => "required",
            "status_id" => ["required","in:3,4"],
        ]);

        $user = Auth::user();
        $user_id = $user["id"];

        try{
            $paymentmethod = Paymentmethod::findOrFail($id);
            $paymentmethod->name = $request["name"];
            $paymentmethod->paymenttype_id = $request["paymenttype_id"];
            $paymentmethod->slug = Str::slug($request["name"]);
            $paymentmethod->status_id = $request["status_id"];
            $paymentmethod->user_id = $user_id;
            $paymentmethod->save();

            if($paymentmethod){
                return response()->json(["status"=>"success","data"=>$paymentmethod]);
            }
            return response()->json(["status"=>"failed","data"=>"Failed to update Payment Method"]);
        }catch(Exception $e){
            Log:error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
        
    }

    public function destroy(Paymentmethod $paymentmethod)
    {
        try{
            if($paymentmethod){
                $paymentmethod->delete();
                return response()->json(["status"=>"success","data"=>$paymentmethod,"message"=>"Delete Successfully"]);
            }
            return response()->json(["status"=>"failed","message"=>"No Data Found"]);
        }catch(Exception $e){
            Log::error($e->getmessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

    public function typestatus(Request $request){
        $paymentmethod = Paymentmethod::findOrFail($request["id"]);
        $paymentmethod->status_id = $request["status_id"];
        $paymentmethod->save();

        return response()->json(["success"=>"Status Change Successfully"]);
    }

    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            Paymentmethod::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }
}
