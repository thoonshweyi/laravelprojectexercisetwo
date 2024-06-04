<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Leave extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = "leaves";
    protected $primaryKey = "id";
    protected $fillable = [
        "post_id",
        "startdate",
        "enddate",
        "tag",
        "title",
        "content",
        "image",
        "stage_id",
        "authorize_id",
        "user_id",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function stage(){
        return $this->belongsTo(Stage::class);
    }

    public function student($userid){
        
        $students = Student::where("user_id",$userid)->get()->pluck("regnumber");

        foreach($students as $student){
            return $student;
        }
    }

    public function studenturl(){
        return Student::where("user_id",$this->user_id)->get(["students.id"])->first();
    }

    public function tagperson(){
        return $this->belongsTo(User::class,"tag");
    }
}
