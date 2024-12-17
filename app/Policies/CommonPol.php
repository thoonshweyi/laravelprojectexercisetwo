<?php

namespace App\Policies;

use App\Models\User;

class CommonPol
{
    public function __construct()
    {
        
    }

    public function view(User $user){
           return $user->hasPermission('view_resource'); 
    }

    public function create(User $user){
        return $user->hasPermission('create_resource'); 
    }

    public function edit(User $user,$model){
        // return $user->hasPermission('edit_resource') || $model->user_id == $user->id;
        return $user->hasPermission('edit_resource') || $user->isOwner($model); 
        // return $user->hasPermission('edit_resource') || ($user->isOwner($model) && $user->hasPermission('edit_own_resource')); 
    }

    public function delete(User $user,$model){
        return $user->hasPermission('delete_resource') || $user->isOwner($model); 
    }
}
