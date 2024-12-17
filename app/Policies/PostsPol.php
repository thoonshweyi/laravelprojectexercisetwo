<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostsPol
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }

    public function view(User $user){
           return $user->hasPermission('view_resource'); 
    }

    public function create(User $user){
        return $user->hasPermission('create_resource'); 
    }

    public function edit(User $user,Post $post){
        // return $user->hasPermission('edit_resource') || $post->user_id == $user->id;
        return $post->user_id == $user->id || $user->hasRoles(['Admin','Teacher']);
    }

    public function update(User $user,Post $post){
        return $user->isOwner($post) || $user->hasRoles(['Admin','Teacher']); 
    }

    public function delete(User $user,Post $post){
        return $user->hasPermission('delete_resource') || $user->isOwner($post) || $user->hasRoles(['Admin','Teacher']);
    }
}
