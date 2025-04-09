<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
class PostsController extends Controller
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
        $posts = Post::latest()->take(3)->get();

        $datas = $posts->map(function($post){
            return [
                'id' => $post->id,
                'image' => $post->image ?? '/assets/img/fav/favicon.png',
                'title' => $post->title,
                'fee' => $post->fee,
                'status' => $post['status']['name'],
                'created_at' => $post->created_at->format('d M Y'),
            ];
        });
   
        return response()->json($datas);
    }
}
