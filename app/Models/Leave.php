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

    public function leavefiles(){
        return $this->hasMany(LeaveFile::class);
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

    public function tagpersonurl($tagid){
        // return Student::where("user_id",$tagid)->get(["students.id"])->first();
        return Student::where("user_id",$tagid)->value('id');
    }

    public function tagposts($postjson){
        $postids = json_decode($postjson,true); // Decode Json-encoded tags

        $posts = Post::whereIn('id',$postids)->pluck('title','id'); // Fetch users in a single query
        return $posts;
    }

    // public function tagperson(){
    //     return $this->belongsTo(User::class,"tag");
    // }

    public function tagpersons($tagjson){
        $tagids = json_decode($tagjson,true); // Decode Json-encoded tags

        $tags = User::whereIn('id',$tagids)->pluck('name','id'); // Fetch users in a single query
        return $tags;
    }

    public function maptagtonames($users = null){
        $tagids = json_decode($this->tag,true); // Decode Json-encoded tags
        $tagnames = collect($tagids)->map(function($id) use($users){
             return $users[$id];
        });
        return $tagnames->join(", ");
    }

    public function isconverted(){
        return $this->stage_id != 2; // 2 = pending
    }
}
