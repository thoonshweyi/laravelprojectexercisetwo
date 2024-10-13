<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\City;
use App\Models\Gender;
use App\Models\Lead;
use App\Models\Student;
use App\Models\StudentPhone;
use App\Models\Enroll;
use App\Mail\MailBox;
use App\Jobs\MailBoxJob;
use App\Jobs\StudentMailBoxJob;
use App\Mail\StudentMailBox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;



class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view("students.index",compact("students"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("students.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // dd(count($request->phone)); // 1
        // dd($request->phone); // array:1 [0 => null]
        $this->validate($request,[
            "firstname"=>"required",
            "lastname"=>"required",
            "remark" => "max:1000"
       ]);

       $user = Auth::user();
       $user_id = $user->id;

       $student = new Student();
       $student->firstname = $request["firstname"];
       $student->lastname = $request["lastname"];
       $student->slug = Str::slug($request["firstname"]);
       $student->remark = $request["remark"];
       $student->user_id = $user_id;
       $student->save();

        //Create New Student Phone 
        if(!empty($request["phone"])){
            // Method 1

            // foreach($request["phone"] as $phone){
            //     $phonedatas = [
            //         'student_id'=> $student["id"],
            //         'phone'=>$phone
            //     ];
            //     StudentPhone::insert($phonedatas);
            // }


            // Method 2
            foreach($request->phone as $phone){
                $student->studentphones()->create([
                   'student_id'=> $student["id"],
                   'phone'=>$phone
                ]);
            }

        }

       return redirect(route("students.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findOrFail($id);

        // $enrolls = Enroll::where("user_id",$student["user_id"])->get();
        $enrolls = $student->enrolls();
        // dd($enrolls);

        $studentphones = $student->studentphones;
        // dd($studentphones);

        return view("students.show",["student"=>$student,"enrolls"=>$enrolls,"studentphones"=>$studentphones]);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        $studentphones = StudentPhone::where("student_id",$id)->get();
        
        $genders = Gender::orderBy("name","asc")->get();
        $countries = Country::orderBy("name","asc")->where("status_id",3)->get();
        $cities = City::orderBy("name","asc")->where("status_id",3)->where("country_id",$student->country_id)->get();
        
        return view("students.edit")->with("student",$student)->with("studentphones",$studentphones)->with("genders",$genders)->with("countries",$countries)->with("cities",$cities);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            // "regnumber" => "required|unique:students,regnumber",
            // "regnumber" => "required|unique:students,regnumber,".$id,
            "firstname"=>"required",
            "lastname"=>"required",
            "remark" => "max:1000"
       ]);

       $user = Auth::user();
       $user_id = $user["id"];

       $student = Student::findOrFail($id);
    //    $student->regnumber = $request["regnumber"];
       $student->firstname = $request["firstname"];
       $student->lastname = $request["lastname"];
       $student->slug = Str::slug($request["firstname"]);
       $student->gender_id = $request["gender_id"];
       $student->age = $request["age"];
       $student->email = $request["email"];
       $student->country_id = $request["country_id"];
       $student->city_id = $request["city_id"];
       $student->remark = $request["remark"];
       $student->user_id = $user_id;

       $student->save();

       //Create/Update New Student Phone 
        if(!empty($request["newphone"])){
            // Method 1

            // extend new phone
            foreach($request["newphone"] as $newphone){
                $newphonedatas = [
                    'student_id'=> $student["id"],
                    'phone'=>$newphone
                ];
                StudentPhone::insert($newphonedatas);

            }
        
            foreach($request->phone as $key=>$phone){
                StudentPhone::findOrFail($request["studentphoneid"][$key])->update([
                    'phone'=>$phone
                ]);
            }

    

        }else{
            // update existing phone 
            foreach($request->phone as $key=>$phone){
                StudentPhone::findOrFail($request["studentphoneid"][$key])->update([
                    'phone'=>$phone
                ]);
            }
        }

       return redirect(route("students.index"));
    }
    // *slug name will be updated, when the firstname is modified
    // - validation error and the updated information is not stored 
    //      if check "regnumber" Unique and we only change firstname, not the regnumber field
    // -Unique check the field is not exist in the database table

    // - Forcing A Unique Rule To Ignore A Given ID
    //      unique rule pass for the student id.
    //      *update() must carefully specify id to ignore unique rule

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->back();
    }

    public function mailbox(Request $request){
        // dd($request["cmpemail"]);        // "admin@gmail.com"
        // dd($request["cmpsubject"]);      // "very important" // app\Http\Controllers\StudentsController.php:131
        // dd($request["cmpcontent"]);      // "hello" // app\Http\Controllers\StudentsController.php:132
        
        // Method 1 (to MailBox)
        // $to = $request["cmpemail"];
        // $subject = $request["cmpsubject"];
        // $content = $request["cmpcontent"];
        // Mail::to($to)->send(new MailBox($subject,$content));
        // Mail::to($to)->cc("admin@dlt.com")->bcc("info@dlt.com")->send(new MailBox($subject,$content));

        // =>Usng Jog Method 1 (to MailBox)
        // dispatch(new MailBoxJob($to,$subject,$content));
        // MailBoxJob::dispatch($to,$subject,$content);

        // =>Method 2 (to StudentMailBox)
        // $data["to"] = $request["cmpemail"];
        // $data["subject"] = $request["cmpsubject"];
        // $data["content"] = $request["cmpcontent"];

        $data = [
            "to" => $request["cmpemail"],
            "subject" => $request["cmpsubject"],
            "content" => $request["cmpcontent"]
        ];
        
        // Mail::to($data["to"])->send(new StudentMailBox($data));
        dispatch(new StudentMailBoxJob($data));

        return redirect()->back();
    }

    public function quicksearch(Request $request){
        $students = "";

        if($request->keyword != ""){
            $students = Student::where("regnumber","LIKE","%".$request->keyword."%")->get();
        }
        return response()->json(["datas"=>$students]);
    }
    
}
