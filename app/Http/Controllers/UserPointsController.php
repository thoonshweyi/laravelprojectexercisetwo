<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Models\Student;
use App\Models\UserPoint;
use App\Models\User;

class UserPointsController extends Controller
{
    public function index(){

        if(request()->ajax()){
            $userpoints = UserPoint::all();
            return view("userpoints.list",compact("userpoints"))->render();
        }
        return view("userpoints.index");
    }

    public function store(Request $request){
        $request->validate([
            "points"=>"required|numeric",
        ]);
        UserPoint::create($request->all());
        return response()->json(["message"=>"New Point Created"],201);
    }

    public function show($id){
        $userpoint = UserPoint::findOrFail($id);
        return response()->json($userpoint);
    }

    public function update(Request $request,$id){
        $userpoint = UserPoint::findOrFail($id);
        $userpoint->update($request->all());  
        return response()->json(["message"=>"Update Successfully"],201);
    }

    public function destroy($id){
        UserPoint::destroy($id);
        return response()->json(["message"=>"Delete Successfully"],201);
    }

    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            UserPoint::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

    public function search(Request $request){

        $userpoints = UserPoint::all();
        
        $query = $request->input("query");
        if($query){
            
            $users = UserPoint::users($query);
            // dd($users);
            

            $userpoints = UserPoint::whereIn("user_id",$users)->get();
        }

        return view("userpoints.list",compact("userpoints"))->render();

    }

    public function verifystudent(Request $request){
        $student = Student::where("regnumber",$request->studentid)->select(["id","firstname","lastname","user_id"])->first(); // we must have to call user_id
        $user =  $student->user()->select(["id"])->first();

        if($user){
            return response()->json(["student"=>$student,"user"=>$user]);
        }else{
            return response()->json(["message"=>"No corresponding user found",404]);
        }
    }

}
