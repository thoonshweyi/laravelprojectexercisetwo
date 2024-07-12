<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\PostViewDuration;

class PostViewDurationsController extends Controller
{
    public function trackduration(Request $request){
        // need to convert laravel timing format to get time diff
        // $entrytime = Session::get("entrytime"); // entrytime: "2024-06-26T08:47:53.197613Z"
        // $exittime = $request->input("exittime"); // exittime: "2024-06-26T08:47:52.656Z"
        
        $entrytime = Carbon::parse(Session::get("entrytime"));  // entrytime: "2024-06-26T09:09:00.695128Z"
        $exittime = Carbon::parse($request->input("exittime")); // exittime: "2024-06-26T09:09:00.243000Z"
        $postid = Session::get("post_id")->id;
        $user_id = Auth::id(); 

        if($entrytime && $exittime && $postid && $user_id){

            $durationinseconds = $entrytime->diffInSeconds($exittime);
            // $durationinminutes = $entrytime->diffInMinutes($exittime);

            $postviewduration = new PostViewDuration();
            $postviewduration->user_id = $user_id; 
            $postviewduration->post_id = $postid; 
            $postviewduration->duration = $durationinseconds; 
            $postviewduration->save();

            // Clear Session Variable 
            Session::forget("entrytime");
            Session::forget("post_id");
        }

        // return response()->json(["status"=>"success","entrytime"=>$entrytime,"exittime"=>$exittime,"postid"=>$postid,"duration"=>$durationinseconds]);
        return response()->json(["status"=>"success"]);
        
    }
}
