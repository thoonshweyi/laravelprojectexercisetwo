<?php

namespace App\Policies;

use App\Models\Leave;
use App\Models\User;

class LeavePol
{
    public function __construct()
    {
        
    }

    // Admin can view all leave data 
    public function viewany(User $user){
        // check if the user has the 'Admin' role
        return $user->hasRoles(['Admin']);
    }

    // Users can view their own leave datas
    public function view(User $user,Leave $leave){
        // allow if the user has the required permission or is the owner of the leave
        return $user->hasPermission('view_resource') || $user->isOwner($leave); 
    }
 
    public function create(User $user){
        return $user->hasRoles(['Teacher','Student']);
    }

    public function edit(User $user,Leave $leave){
        // allow Admin, Teacher to edit all leave records
        if($user->hasRoles(['Admin','Teacher'])){
            return true;
        }
        // allow users to edit their own leave records
        return $leave->user_id == $user->id; 
    }

    public function update(User $user,Leave $leave){
        if($user->hasRoles(['Admin','Teacher'])){
            return true;
        }
        return $user->isOwner($leave); 
    }

    public function delete(User $user,Leave $leave){
        if($user->hasRoles(['Admin','Teacher'])){
            return true;
        }
        return $user->hasPermission('delete_resource') || $user->isOwner($leave); 
    }
}
