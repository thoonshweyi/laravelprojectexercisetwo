<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function comments(){
        return $this->morphMany(Comment::class,"commentable");
    }

    public function likes(){
        return $this->belongsToMany(Post::class,"post_like")->withTimestamps();
    }
    public function checkpostlike($postid){
        return $this->likes()->where("post_id",$postid)->exists();
    }

    public function followings(){
                                                                // fk           // rk (relative key)
        return $this->belongsToMany(User::class,"follower_user","follower_id","user_id")->withTimestamps();
    }

    public function checkuserfollowing($followingid){
        return $this->followings()->where("user_id",$followingid)->exists();
    
        // Note:: user_id mean = Oher Person 
        // Note:: follower_id mean = I
        // Note:: $followingid mean = Other Person
    }

    public function scopeOnlineusers($query){
        return $query->where("is_online",1)->get();
    }
    public function scopeOfflineusers($query){
        return $query->where("is_online",0)->get();
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function userpoints(){
        return $this->hasOne(UserPoint::class);// no need loop
    }

    public function lead(){
        return $this->hasOne(Lead::class);
    }

    public function student(){
        return $this->hasOne(Student::class,'email','email');
    }

    public function roles(){
        // return $this->belongsToMany(Role::class);
        return $this->belongsToMany(Role::class,"role_users");
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,"permission_roles");
    }

    // for single role from route
    // public function hasRole($rolename){
    //     return $this->roles()->where('name',$rolename)->exists();
    // }

    // for multi roles from route
    public function hasRoles($rolenames){
        return $this->roles()->whereIn('name',$rolenames)->exists();
    }

    public function hasPermission($permissionname){
        return $this->roles()->whereHas('permissions',function($query) use ($permissionname){
            $query->where('name',$permissionname);
        })->exists();
    }

    public function isOwner($model){
        return $this->id === $model->user_id;
    }

    public function getAdminEmail(){
        $adminemail = User::find(1)->email;
        // dd($admin);
        return $adminemail;
    }
}
