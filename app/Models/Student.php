<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";
    protected $primaryKey = "id";
    protected $fillable = [
        "regnumber",
        'image',
        "firstname",
        "lastname",
        "slug",
        'dob',
        'gender_id',
        'age',
        'email',
        'country_id',
        'city_id',
        'region_id',
        'township_id',
        'address',
        'religion_id',
        'nationalid',
        "remark",
        "status_id",
        "user_id"
    ];

    public function user(){
        return $this->belongsTo("App\Models\User"); // send all column
    }

    public function gender(){
        return $this->belongsTo(Gender::class); // send all column
    }

    public function country(){
        return $this->belongsTo(Country::class); // send all column
    }

    public function city(){
        return $this->belongsTo(City::class); // send all column
    }

    public function region(){
        return $this->belongsTo(Region::class); // send all column
    }

    public function township(){
        return $this->belongsTo(Township::class); // send all column
    }

    public function religion(){
        return $this->belongsTo(Religion::class); // send all column
    }

    public function status(){
        // return $this->belongsTo(Status::class); // send all column
        // return $this->belongsTo(Status::class)->select("name"); // send single column
        return $this->belongsTo(Status::class)->select(["id","name","slug"]); // send multi column
    }

    public function enrolls(){
        return Enroll::where("user_id",$this->user_id)->get();
    }

    // Method 1 (can duplicate regnumber)
    // protected static function boot(){
    //     parent::boot();

    //     static::creating(function($student){
    //         $lateststudent = \DB::table("students")->orderBy("id","desc")->first();
    //         $latestid= $lateststudent ?  $lateststudent->id : 0;
    //                                 // str_pad(string,length,pad_string,pad_types);
    //         $student->regnumber = "WDF".str_pad($latestid+1,5,"0",STR_PAD_LEFT);
    //     });
    // }

    // Method 2 (solved duplicated regnumber)
    protected static function boot(){
        parent::boot();

        static::creating(function($student){
            $student->regnumber = self::generatestudentid();
        });
    }

    protected static function generatestudentid(){
        return \DB::transaction(function(){
            $lateststudent = \DB::table("students")->orderBy("id","desc")->first();
            $latestid= $lateststudent ?  $lateststudent->id : 0;
            $newstudentid = "WDF".str_pad($latestid+1,5,"0",STR_PAD_LEFT);
            
            while(\DB::table("students")->where("regnumber",$newstudentid)->exists()){
                $latestid++;
                $newstudentid = "WDF".str_pad($latestid+1,5,"0",STR_PAD_LEFT);
            }
            return $newstudentid;
        });
    }

    public function studentphones(){
        return $this->hasMany(StudentPhone::class); 
    }

    public function calculateProfileScore(){
        
        $fields = [
            "firstname",
            "lastname",
            'dob',
            'gender_id',
            'age',
            'email',
            'country_id',
            'city_id',
            'region_id',
            'township_id',
            'address',
            'religion_id',
            'nationalid',
        ];

        $score = 0;

        // profile picture uploaded
        if($this->hasprofilepicture()){
            $score += 10;
        }

        foreach($fields as $field){
            if(!empty($this->$field)){
                $score += 10;
            }
        }


        $phonescore = $this->studentphones()->count();
        if($phonescore > 0){
            $phonescore = $phonescore * 10;
        }

        $score = $this->convertScoreToPercentage($score+$phonescore);
        $this->profile_score = $score;
        $this->save();

        return $score;
    }
    public function hasprofilepicture(){
        return !empty($this->image);
    }

    public function convertScoreToPercentage($score){
        $maxscore = 170; // Assuming 170 is the max score (varying total score points of fields)
        $percentage = ($score/$maxscore) * 100;
        return $percentage;
    }

    public function isProfileLocked(){
        return $this->calculateProfileScore() === 100;
    }
}
