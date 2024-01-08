<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Type;


class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view("posts.index",compact("posts"));
    }

    public function create()
    {    
        $attshows = Status::whereIn("id",[3,4])->get();
        $statuses = Status::whereIn("id",[7,10,11])->get();
        $tags = Tag::where("status_id",3)->get();
        $types = Type::whereIn("id",[1,2])->get();

        return view("posts.create",compact("attshows","statuses","tags","types"));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            "image" => "image|mimes:jpg,jpeg,png|max:1024",
            "title" => "required|max:50|unique:posts,title",
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
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $post = new Post();
       $post->title = $request["title"];
       $post->slug = Str::slug($request["name"]);
       $post->content = $request["content"];
       $post->fee = $request["fee"];
       $post->startdate = $request["startdate"];
       $post->enddate = $request["enddate"];
       $post->starttime = $request["starttime"];
       $post->endtime = $request["endtime"];
       $post->type_id = $request["type_id"];
       $post->tag_id = $request["tag_id"];
       $post->attshow = $request["attshow"];
       $post->status_id = $request["status_id"];
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
       return redirect(route("posts.index"));
    }

    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view("posts.show",["post"=>$post]);
    }


    public function edit(string $id)
    {

        $post = Post::findOrFail($id);
        $attshows = Status::whereIn("id",[3,4])->get();
        $statuses = Status::whereIn("id",[7,10,11])->get();
        $tags = Tag::where("status_id",3)->get();
        $types = Type::whereIn("id",[1,2])->get();

        return view("posts.edit")->with("post",$post)->with("attshows",$attshows)->with("statuses",$statuses)->with("tags",$tags)->with("types",$types);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "image" => "image|mimes:jpg,jpeg,png|max:1024",
            "title" => "required|max:50|unique:posts,title,".$id,
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
        ]);

        $user = Auth::user();
        $user_id = $user["id"];

        $post = Post::findOrFail($id);
        $post->title = $request["title"];
        $post->slug = Str::slug($request["name"]);
        $post->content = $request["content"];
        $post->fee = $request["fee"];
        $post->startdate = $request["startdate"];
        $post->enddate = $request["enddate"];
        $post->starttime = $request["starttime"];
        $post->endtime = $request["endtime"];
        $post->type_id = $request["type_id"];
        $post->tag_id = $request["tag_id"];
        $post->attshow = $request["attshow"];
        $post->status_id = $request["status_id"];
        $post->user_id = $user_id;


        // Remove Old Image
        if($request->hasFile("image")){
            $path = $post->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Update
        if($request->hasFile("image")){
            $file = $request->file("image");
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$post['id'].$fname;
            $file->move(public_path("assets/img/posts"),$imagenewname);
            
            $filepath = "assets/img/posts/".$imagenewname;
            $post->image = $filepath;
        }    

        $post->save();
        return redirect(route("posts.index"));
    }


    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        
        // Remove Old Image
        $path = $post->image;
        if(File::exists($path)){
            File::delete($path);
        }
        
        $post->delete();
        return redirect()->back();
    }
}
