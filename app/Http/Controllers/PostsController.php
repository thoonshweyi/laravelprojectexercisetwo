<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

use Illuminate\Support\Str;
use App\Models\Comment;
use App\Models\Day;
use App\Models\Dayable;
use App\Models\Post;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Type;


class PostsController extends Controller
{
    public function index()
    {
            // $this->authorize('view',Post::class);

        $posts = Post::orderBy('created_at','desc')->get();
        return view("posts.index",compact("posts"));
    }

    public function create()
    {    
            $this->authorize('create',Post::class);


        $attshows = Status::whereIn("id",[3,4])->get();
        $days = Day::where("status_id",3)->get();
        $statuses = Status::whereIn("id",[7,10,11])->get();
        $tags = Tag::where("status_id",3)->get();
        $types = Type::whereIn("id",[1,2])->get();

        $gettoday = Carbon::today()->format("Y-m-d");
        $gettime = Carbon::now()->format("H:i");

        return view("posts.create",compact("attshows","days","statuses","tags","types","gettoday","gettime"));
    }


    public function store(Request $request)
    {
        $this->authorize('create',Post::class);
        
        $this->validate($request,[
            "image" => "image|mimes:jpg,jpeg,png|max:1024",
            "title" => "required|max:50|unique:posts,title",
            "content" => "required",
            "fee" => "required|numeric",
            "startdate" => "required",
            "enddate" => "required",
            "starttime" => "required",
            "endtime" => "required",
            "type_id" => "required|in:1,2",
            "tag_id" => "required",
            "attshow" => "required|in:3,4",
            "status_id" => "required|in:7,10,11",   
            "day_id"=>"required|array",
            'day_id.*'=>"exists:days,id"
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $post = new Post();
        $post->fill($request->only([
            'title', 'content' , 'fee' , 'startdate' , 'enddate', 'starttime','endtime','type_id','tag_id', 'attshow','status_id'
        ]));

       $post->slug = Str::slug($request["name"]);
       $post->user_id = $user_id;

        // Single Image Upload
        if(file_exists($request["image"])){
            $file = $request["image"];
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$post['id'].$fname;
            // $file->move(public_path("posts/img"),$imagenewname);
            $file->move(public_path("assets/img/posts"),$imagenewname);
            
            $filepath = "assets/img/posts/".$imagenewname;
            $post->image = $filepath;
        }    
        $post->save();

       
        if($post->id && $request->has('day_id')){
            // dd($request["day_id"]);

            // create dayable
            // Method 1
            // if(count($request["day_id"]) > 0){
                
            //     foreach($request["day_id"] as $key=>$value){
            //         Dayable::create([
            //             // "day_id"=>$request["day_id"][$key],
            //             "day_id"=>$value,
            //             "dayable_id"=>$post->id,
            //             "dayable_type"=>$request["dayable_type"]
            //         ]);
            //     }
            // }

            // Methd 2
            // if(count($request["day_id"]) > 0){
                            
            //     foreach($request["day_id"] as $key=>$value){
            //         $day = [
            //             // "day_id"=>$request["day_id"][$key],
            //             "day_id"=>$value,
            //             "dayable_id"=>$post["id"],
            //             "dayable_type"=>$request["dayable_type"]
            //         ];
            //         Dayable::insert($day);
            //     }
            // }

            // Method 3
            $day = array_map(function($dayid) use ($post,$request){
                return [
                    "day_id"=>$dayid,
                    "dayable_id"=>$post["id"],
                    "dayable_type"=>$request["dayable_type"]    // Post::class
                ];
            },$request->day_id);
            Dayable::insert($day);
        }

        // Email Noti
       
       return redirect(route("posts.index"));
    }

    public function show(Post $post)
    {
            $this->authorize('view',$post);


        // dd($post->checkenroll(1)); // true

        // $comments = Comment::where("commentable_id",$post->id)->where("commentable_type","App\Models\Posts")->orderBy("created_at","desc")->get();
        $comments = $post->comments()->orderBy("updated_at","desc")->get();
        $dayables = $post->days()->get();
        // dd($dayables);

        $user_id = Auth::user()->id;;
        $postviewdurations = $post->postviewdurations()->whereNot("user_id",$user_id)->orderBy("id","desc")->take("10")->get();

        return view("posts.show",["post"=>$post,"comments"=>$comments,"dayables"=>$dayables,"postviewdurations"=>$postviewdurations]);
    }


    public function edit(Post $post)
    {
            $this->authorize('edit',$post);

        $days = Day::where("status_id",3)->get();
        $dayables = $post->days()->get();
        // dd($dayables); // Day object
        $attshows = Status::whereIn("id",[3,4])->get();
        $statuses = Status::whereIn("id",[7,10,11])->get();
        $tags = Tag::where("status_id",3)->get();
        $types = Type::whereIn("id",[1,2])->get();

        return view("posts.edit")->with("post",$post)->with("attshows",$attshows)->with("days",$days)->with("dayables",$dayables)->with("statuses",$statuses)->with("tags",$tags)->with("types",$types);
    }

    public function update(Request $request, Post $post)
    {
            $this->authorize('update',$post);

        $this->validate($request,[
            "image" => "image|mimes:jpg,jpeg,png|max:1024",
            "title" => "required|max:50|unique:posts,title,".$post->id,
            "content" => "required",
            "fee" => "required",
            "startdate" => "required",
            "enddate" => "required",
            "starttime" => "required",
            "endtime" => "required",
            "type_id" => "required|in:1,2",
            "tag_id" => "required",
            "attshow" => "required|in:3,4",
            "status_id" => "required|in:7,10,11",   
            "day_id"=>"required|array",
            'day_id.*'=>"exists:days,id"
        ]);

        $user = Auth::user();
        $user_id = $user["id"];

        $post->fill($request->only([
            'title', 'content' , 'fee' , 'startdate' , 'enddate', 'starttime','endtime','type_id','tag_id', 'attshow','status_id'
        ]));

        $post->slug = Str::slug($request["name"]);
        $post->user_id = $user_id;



        if($request->hasFile("image")){
            // Remove Old Image
            $path = $post->image;
            if(File::exists($path)){
                File::delete($path);
            }

            // Single Image Update
            $file = $request->file("image");
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$post['id'].$fname;
            $file->move(public_path("assets/img/posts"),$imagenewname);
            
            $filepath = "assets/img/posts/".$imagenewname;
            $post->image = $filepath;
        }    

        $post->save();

        // Update Days 
        $post->days()->sync($request->day_id);


        return redirect(route("posts.index"));
    }


    public function destroy(Post $post)
    {
            $this->authorize('delete',$post);

        
        // Remove Old Image
        $path = $post->image;
        if(File::exists($path)){
            File::delete($path);
        }
        
        // Delete post and it's related Dayable records
        // Method 1
        // Dayable::where('dayable_id',"=",$post['id'])->delete();

        // Method 2
        $post->days()->detach();

        $post->delete();
        return redirect()->back();
    }
}
