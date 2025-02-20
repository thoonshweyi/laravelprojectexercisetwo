<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveNotify;

use App\Models\Leave;
use App\Models\LeaveFile;
use App\Models\Stage;
use App\Models\User;

class LeavesController extends Controller
{
    public function index()
    {
        if(auth()->user()->can('viewany',Leave::class)){
            $leavesQuery = Leave::query(); // Admin,Teacher can see all leaves
        }else{
            $leavesQuery = Leave::where('user_id',auth()->id());
        }
        $leaves = $leavesQuery
                    ->orderBy('startdate','desc')
                    ->get();

        $totalleaves = $leaves->count();
        $approvedcount = $leaves->where('stage_id',1)->count();
        $pendingcount = $leaves->where('stage_id',2)->count();
        $rejectedcount = $leaves->where('stage_id',3)->count();


        $users = User::pluck('name','id');
        return view("leaves.index",compact("leaves","totalleaves","approvedcount","pendingcount","rejectedcount","users"));
    }

    public function create()
    {    
            $this->authorize('create',Leave::class);
        $data["posts"] = \DB::table("posts")->where("attshow",3)->orderBy("title","asc")->pluck("title","id");
        $data["tags"] = User::whereHas('roles',function($query){
            $query->whereIn('name',['Admin','Teacher']);
        })->orderBy("name","asc")->get()->pluck("name","id");
        $data["gettoday"] = Carbon::today()->format("Y-m-d"); // get today // "2024-02-26"
        // dd($data["gettoday"]);
        return view("leaves.create",$data);
    }


    public function store(LeaveRequest $request)
    {
        // $this->validate($request,[
        //     "post_id" => "required",
        //     "startdate" => "required",
        //     "enddate" => "required",
        //     "tag" => "required",
        //     "title" => "required|max:50",
        //     "content" => "required",
        //     "image" => "nullable|image|mimes:jpg,jpeg,png|max:1024",
        // ]);

       $user = Auth::user();
       $user_id = $user->id;

       $leave = new Leave();
       $leave->post_id = json_encode($request["post_id"]);
       $leave->startdate = $request["startdate"];
       $leave->enddate = $request["enddate"];
       $leave->tag = json_encode($request["tag"]);
       $leave->title = $request["title"];
       $leave->content = $request["content"];
       $leave->user_id = $user_id;
 
        $leave->save();

        // Multi Images Upload 
        if($request->hasFile('images')){
            foreach($request->file("images") as $image){
                $leavefile = new LeaveFile();
                $leavefile->leave_id = $leave->id;

                $file = $image;
                $fname = $file->getClientOriginalName();
                $imagenewname = uniqid($user_id).$leave['id'].$fname;
                $file->move(public_path('assets/img/leaves/'),$imagenewname);


                $filepath = 'assets/img/leaves/'.$imagenewname; 
                $leavefile->image = $filepath;

                $leavefile->save();
            }
        }
        
        session()->flash("success","New Leave Created");

        // Notify to single tagged user
        // $users = User::all();
        // $tagperson = $leave->tagperson()->get();
        // dd($tagperson);
        // $studentid = $leave->student($user_id);
        // Notification::send($tagperson,new LeaveNotify($leave->id,$leave->title,$studentid));
        
        
        // =>Notify to multi tagged users
        $tags = $request['tag'];
        $tagpersons = User::whereIn('id',$tags)->get(); // fetch all users at once
        $studentid = $leave->student($user_id);
        Notification::send($tagpersons,new LeaveNotify($leave->id,$leave->title,$studentid));



        return redirect(route("leaves.index"));
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $leave = Leave::findOrFail($id);   
        $leavefiles = LeaveFile::where('leave_id',$id)->get(); // load all assiciated images
        $stages = Stage::whereIn('id',[1,2,3])->where("status_id",3)->get();


        $type = "App\Notifications\LeaveNotify";
        $getnoti = \DB::table("notifications")->where("notifiable_id",$user_id)->where("type",$type)->where('data->id',$id)->pluck('id');
        // dd($getnoti);
        if(count($getnoti) != 0){
            \DB::table("notifications")->where('id',$getnoti)->update(["read_at"=>now()]);
        }
        return view("leaves.show",["leave"=>$leave,"leavefiles"=>$leavefiles,"stages"=>$stages]);
    }


    public function edit(string $id)
    {

        $data["leave"] = Leave::findOrFail($id);
        $data["leavefiles"] = LeaveFile::where('leave_id',$id)->get(); // load all assiciated images
            $this->authorize('edit',$data['leave']);

        $data["posts"] = \DB::table("posts")->where("attshow",3)->orderBy("title","asc")->pluck("title","id");
        $data["tags"] = User::whereHas('roles',function($query){
            $query->whereIn('name',['Admin','Teacher']);
        })->orderBy("name","asc")->get()->pluck("name","id");

        return view("leaves.edit",$data);
    }

    public function update(LeaveRequest $request, string $id)
    {
        // $this->validate($request,[
        //     "post_id" => "required",
        //     "startdate" => "required",
        //     "enddate" => "required",
        //     "tag" => "required",
        //     "title" => "required|max:50",
        //     "content" => "required",
        //     "image" => "nullable|image|mimes:jpg,jpeg,png|max:1024",
        // ]);

        $user = Auth::user();
        $user_id = $user["id"];

        $leave = Leave::findOrFail($id);
            $this->authorize('edit',$leave);

        $leave->post_id = json_encode($request["post_id"]);
        $leave->startdate = $request["startdate"];
        $leave->enddate = $request["enddate"];
        $leave->tag = json_encode($request["tag"]);
        $leave->title = $request["title"];
        $leave->content = $request["content"];

        if($leave->isconverted()){
            return redirect()->back()->with('error',"This leave for has already been converted to an authorized stage. Editing is disabled.");
        }

        $leave->save();

        if($request->hasFile('images')){

            // Remove Old Image
            $leavefiles = LeaveFile::where('leave_id',$leave->id)->get();
            foreach($leavefiles as $leavefile){
                $path = $leavefile->image;

                if(File::exists($path)){
                    File::delete($path);
                }
            }

            // Remove Old Image Path
            LeaveFile::where('leave_id',$leave->id)->delete();

            // Multi Images Upload 
            foreach($request->file("images") as $image){
                $leavefile = new LeaveFile();
                $leavefile->leave_id = $leave->id;

                $file = $image;
                $fname = $file->getClientOriginalName();
                $imagenewname = uniqid($user_id).$leave['id'].$fname;
                $file->move(public_path('assets/img/leaves/'),$imagenewname);


                $filepath = 'assets/img/leaves/'.$imagenewname; 
                $leavefile->image = $filepath;

                $leavefile->save();
            }
        }

        

        session()->flash("success","Update Successfully");

        return redirect(route("leaves.index"));
    }


    public function destroy(string $id)
    {
        $leave = Leave::findOrFail($id);
            $this->authorize('delete',$leave);

        if($leave->isconverted()){
            return redirect()->back()->with('error',"Already been converted to an authorized stage. Delete function is not allowed.");
        }
    
        // Remove Old Image
        $leavefiles = LeaveFile::where('leave_id',$id)->get();
        foreach($leavefiles as $leavefile){
            $path = $leavefile->image;
            if(File::exists($path)){
                File::delete($path);
            }
        }
        // Delete associate records from database
        LeaveFile::where('leave_id',$leave->id)->delete();

        $leave->delete();
        return redirect()->back();
    }

    public function markasread(){
        $user = Auth::user();
        $user_id = $user->id;

        // $user->unreadNotifications->markAsRead();
        // $user->notifications()->delete(); // all delete (r/un)

        // $user = User::findOrFail($user_id);
        $user = User::findOrFail(auth()->user()->id);
        foreach ($user->unreadNotifications as $notification) {
            // $notification->markAsRead();

            $notification->delete(); // all delete (un)
        }

        return redirect()->back();
    }

    public function updatestage(Request $request,$id){
        $leave = Leave::findOrFail($id);
        $leave->stage_id = $request->stage_id;
        $leave->save();

        return redirect()->back()->with("success","Stage update Successfully");
    }
}
