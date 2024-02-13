<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Enroll extends Model
{
    use HasFactory;
    protected $table = "enrolls";
    protected $primaryKey = "id";
    protected $fillable = [
        "image",
        "post_id",
        "user_id",
        "stage_id",
        "remark"
    ];

    public function stage(){
        return $this->belongsTo(Stage::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function student(){
        
        // Method 1
        // $students = Student::where("user_id",$userid)->get();
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student);
        //     // dd($student["regnumber"]);
        //     return $student["regnumber"];
        // }

        // Method 2
        // $students = Student::where("user_id",$userid)->get()->pluck("regnumber");
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student); // "WDF1001"
        //     return $student;
        // }

        // Method 3
        // $students = Student::where("user_id",$this->user_id)->get();
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student);
        //     // dd($student["regnumber"]);
        //     return $student["regnumber"];
        // }

        // Method 4
        // $students = Student::where("user_id",$this->user_id)->get()->pluck("regnumber");
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student); // "WDF1001"
        //     return $student;
        // }

        // Method 5
                                // join(se table,sec table prikey,compare,primary table fkkey)
        // $students = Student::join("users","users.id","=","students.user_id")->where("user_id",$this->user_id)->get();
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student);
        //     return $student["regnumber"];
        // }

        // Method 6
        // $students = Student::join("users","users.id","=","students.user_id")->where("user_id",$this->user_id)->get()->pluck("regnumber");
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student); // "WDF1001"
        //     return $student;
        // }

        // join(sec table, primary table fkkey,compare,sec table prikey)
        
        // // Method 7
        // $students = Student::join("users","users.id","=","students.user_id")->where("user_id",$this->user_id)->get(["users.*","students.*"]);
        // // dd($students);

        // foreach($students as $student){
        //     // dd($student);
        //     return $student["regnumber"];
        // }


        // Method 8
        // $students = Student::join("users","users.id","=","students.user_id")->where("user_id",$this->user_id)->get(["users.name","students.regnumber"])->first();
        // // dd($students);
        // // dd($students["regnumber"]); // "WDF1001"
        // return $students["regnumber"];

        // Method 9
        // $students = Student::join("users","users.id","=","students.user_id")->where("user_id",$this->user_id)->get(["users.name","students.regnumber"])->pluck("regnumber")->first();
        // // dd($students); // "WDF1001"
        // return $students;

        // Method 10
        // $students = DB::table("students")
        //             ->join("users","users.id","=","students.user_id")
        //             ->where("user_id",$this->user_id)
        //             ->get(["users.name","students.regnumber"])
        //             ->pluck("regnumber")->first();
    
        // // dd($students);
        // return $students;

        // Method 11
        $students = DB::table("students")
                    ->select("users.id","users.name","students.regnumber")
                    ->join("users","users.id","=","students.user_id")
                    ->where("user_id",$this->user_id)
                    ->get()
                    ->pluck("regnumber")->first();
    
        // dd($students);
        return $students;
    

        // My Method
        // $student = Student::join("users","students.user_id","=","users.id")->where("users.id",$this->user_id)->get(["students.regnumber"])->first();
        // // dd($student->regnumber);
        // return $student->regnumber;
    }

    public function studenturl(){
        return Student::where("user_id",$this->user_id)->get(["students.id"])->first();
    }
}
