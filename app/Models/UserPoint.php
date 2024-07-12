<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;
    protected $table = "user_points";
    protected $primaryKey = "id";
    protected $fillable = [
        "user_id",
        "points"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function student(){
        $student = Student::join("users","students.user_id","=","users.id")->where("students.user_id",$this->user_id)->select(["regnumber"])->first();
        // dd($student->regnumber);
        return $student->regnumber;
    }

    public static function users($query){
        $users = User::join("students","users.id","=","students.user_id")->where("regnumber","LIke","%$query%")->pluck("users.id");
        return $users;
    }
}
