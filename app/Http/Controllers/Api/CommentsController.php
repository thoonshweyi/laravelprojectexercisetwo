<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function dashboard(){
     
        $comments = Comment::latest()->take(7)->get();
        $datas = $comments->map(function($comment){
             return [
                'id'=> $comment->id,
                'description'=> $comment->description,
                'user' => [
                    'id'=>$comment->user->id ?? null,
                    'name' => $comment->user->name ?? 'Unknown',
                ],
                'commentable'=>[
                    'id'=> $comment->id ?? null,
                    'type'=> class_basename($comment->commentable_type), // Post or Announcement
                    'title' => $comment->commentable->title ?? 'N/A'
                ],
                'created_at'=> $comment->created_at->format('d M Y H:i')
            ];
        });
   
        return response()->json($datas);
   }
}

// => class_basename()
// $post = new Post();
// echo class_basename($post); // Post

// $classname = `App\Models\Announcement`;
// echo class_basename($classname); // Announcement