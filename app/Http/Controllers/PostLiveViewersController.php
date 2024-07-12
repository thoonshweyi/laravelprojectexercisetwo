<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Events\PostLiveViewerEvent;


class PostLiveViewersController extends Controller
{
    public function incrementviewer(Post $post){
        // auto increment to each cache key
        $count = Cache::increment("postliveviewer-count_".$post->id); // different key names for different posts
        broadcast(new PostLiveViewerEvent($count,$post->id));
        return response()->json(["success"=>true]);
    }

    public function decrementviewer(Post $post){
        // auto decrement to each existing cache keyname
        $count = Cache::decrement("postliveviewer-count_".$post->id); // different key names for different posts
        
        if($count < 0){
            $count = 0;
            $count = Cache::put("postliveviewer-count_".$post->id,$count); // different key names for different posts
        }

        broadcast(new PostLiveViewerEvent($count,$post->id));
        
        return response()->json(["success"=>true]);
    }
    // =Normal decreasement
    // postliveviewer-count_15 = 2 (3 - 1)
    // postliveviewer-count_15 = 1 (2 - 1)

    // Error Decreament
    // 3 viewers 
    // php artisan cache:clear
    // 0 viewers on UI 
    // 3 viewers in realworld 
    // One user left 
    // 0 - 1 = -1
    // One user left 
    // -1 - 1 = -2
}
