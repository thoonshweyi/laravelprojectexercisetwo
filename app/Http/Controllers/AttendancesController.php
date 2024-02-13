<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance;
use App\Models\Post;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendancesController extends Controller
{
    public function index()
    {
        $attendances = Attendance::orderBy('updated_at','desc')->get();
        // $posts = Post::where("attshow",3)->get();
        $posts = DB::table("posts")->where("attshow",3)->orderBy("title","asc")->get();
        return view("attendances.index",compact("attendances","posts"));
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

       $attendance = new attendance();
       $attendance->classdate = $request["classdate"];
       $attendance->post_id = $request["post_id"];
       $attendance->attcode = $request["attcode"];
       $attendance->user_id = $user_id;

       $attendance->save();
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
