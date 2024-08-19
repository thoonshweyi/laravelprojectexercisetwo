<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PointsTransfer;
use App\Models\PointTransferHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PointTransfersController extends Controller
{
    public function index(){

        if(request()->ajax()){
            $pointtransferhistories = PointTransferHistory::all();
            return view("pointtransfers.list",compact("pointtransferhistories"))->render();
        }
        return view("pointtransfers.index");
    }

    public function transfers(Request $request){

        $request->validate([
            "receiver_id"=>"required|exists:users,id",
            "points"=>"required|integer|min:1"
        ]);

        $sender = Auth::user();
        $receiver = User::find($request->input("receiver_id"));
        $points = $request->input("points");

        // Ensure that sender to sender are not the same
        if($sender->id === $receiver->id){
            return response()->json(["message"=>"You cannot transfer points to yourself."],400);
        }

        if($sender->userpoints->points < $points){
            return response()->json(["message"=>"Insufficient points."],400);
        }
        
        // Begin a database transaction
        \DB::beginTransaction();
        try{
            // Deduct points from sender
            $sender->userpoints->points -= $points;
            $sender->userpoints->save();

            // Add points to receiver
            $receiver->userpoints->points += $points;
            $receiver->userpoints->save();
            
            // Commit the transaction
            \DB::commit();   

            // POint Transaction Record
            PointsTransfer::create([
                "sender_id"=>$sender->id,
                "receiver_id"=>$receiver->id,
                "points"=>$points
            ]);

            return response()->json(["message"=>"Points transferred successfully"]);

        }catch(\Exception $err){
            // Rollback transaction in case of error occur
            \DB::rollback();

            return response()->json(["message"=>"Error occurred while transferring points","error"=>$err->getmessage()],500);
        }
    }
}

// Initialize points for the user in Register
// $user->userpoints()->create(["points"=>0]);