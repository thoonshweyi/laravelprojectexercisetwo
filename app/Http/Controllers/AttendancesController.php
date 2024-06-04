<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance;
use App\Models\Post;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Carbon\Carbon;

class AttendancesController extends Controller
{
    public function index()
    {
        $attendances = Attendance::orderBy('updated_at','desc')->get();
        // $posts = Post::where("attshow",3)->get();
        $posts = DB::table("posts")->where("attshow",3)->orderBy("title","asc")->get();
        $gettoday = Carbon::today()->format("Y-m-d");
        return view("attendances.index",compact("attendances","posts","gettoday"));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "classdate" => "required|date",
            "post_id" => "required",
            "attcode" => "required"
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $getclassdate = $request["classdate"];
       $getpostid = $request["post_id"];
       $getattcode = Str::upper($request["attcode"]);

       $attendance = new Attendance();
       if($attendance->checkattcode($getclassdate,$getpostid,$getattcode)){
            $attendance->classdate = $getclassdate;
            $attendance->post_id = $getpostid;
            $attendance->attcode = $getattcode;
            $attendance->user_id = $user_id;
    
            $attendance->save();
            session()->flash("success","Att Created");
       }else{
            session()->flash("error","Failed Try Again!");
       }
       return redirect(route("attendances.index"));
       
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "post_id" => "required",
            "attcode" => "required"
        ]);

        $user = Auth::user();
        $user_id = $user["id"];

        $attendance = Attendance::findOrFail($id);
        $attendance->post_id = $request["post_id"];
        $attendance->attcode = $request["attcode"];
        $attendance->save();
        return redirect(route("attendances.index"));
    }

}
