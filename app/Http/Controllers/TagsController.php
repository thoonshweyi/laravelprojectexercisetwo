<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("tags.index",compact("tags","statuses"));
    }


    public function create()
    {
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("tags.create",compact("statuses"));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|max:50|unique:tags",
            "status_id" => "required|in:3,4",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $tag = new Tag();
       $tag->name = $request["name"];
       $tag->slug = Str::slug($request["name"]);
       $tag->status_id = $request["status_id"];
       $tag->user_id = $user_id;
       $tag->save();
       return redirect(route("tags.index"));
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "name" => ["required","max:50","unique:tags,name,".$id],
            "status_id" => ["required","in:3,4"],
        ]);

        $user = Auth::user();
        $user_id = $user["id"];

        $tag = Tag::findOrFail($id);
        $tag->name = $request["name"];
        $tag->slug = Str::slug($request["name"]);
        $tag->status_id = $request["status_id"];
        $tag->user_id = $user_id;
        $tag->save();
        return redirect(route("tags.index"));
    }


    public function destroy(string $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect()->back();
    }
}
