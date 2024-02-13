<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = "attendances";
    protected $primaryKey = "id";
    protected $fillable = [
        "classdate",
        "post_id",
        "attcode",
        "user_id"
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userstu(){
        $student = Student::where("user_id",$this->user_id)->first();

        // dd($student);
        // dd($student->regnumber);
        return $student;
    }
    // *retrieve with get() will get error

    public function student($userid){
        
        // Method 1
        // $students = Student::where("user_id",$userid)->get();
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student);
        //     // dd($student["regnumber"]);
        //     return $student["regnumber"];
        // }

        // Method 2
        $students = Student::where("user_id",$userid)->get()->pluck("regnumber");
        // dd($students);

        foreach($students as $student){
            // dd($student); // "WDF1001"
            return $student;
        }
    }
}
