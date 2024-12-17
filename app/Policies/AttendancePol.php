<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePol
{
    public function __construct()
    {
        
    }

    public function view(User $user){
           return $user->hasPermission('view_resource'); 
    }

    public function create(User $user){
        return $user->hasPermission('create_attendance'); 
    }

    public function edit(User $user,Attendance $attendance){
        // return $user->hasPermission('edit_resource') || $attendance->user_id == $user->id;
        return $user->hasPermission('edit_resource') || $user->isOwner($attendance); 
        // return $user->hasPermission('edit_resource') || ($user->isOwner($attendance) && $user->hasPermission('edit_own_resource')); 
    }

    public function delete(User $user,Attendance $attendance){
        return $user->hasPermission('delete_resource') || $user->isOwner($attendance); 
    }
}
