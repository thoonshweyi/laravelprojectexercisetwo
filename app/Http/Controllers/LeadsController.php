<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Country;
use App\Models\City;
use App\Models\Lead;
use App\Models\Student;
use App\Mail\MailBox;
use App\Jobs\MailBoxJob;
use App\Jobs\LeadMailBoxJob;
use App\Mail\LeadMailBox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return view("leads.index",compact("leads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = Gender::orderBy("name","asc")->get();
        $countries = Country::orderBy("name","asc")->where("status_id",3)->get();
        return view("leads.create",compact("genders","countries"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $this->validate($request,[
            "firstname"=>"required|string|max:100",
            "gender_id"=>"required|exists:genders,id",
            "age" => "required|integer|min:13|max:45",
            "email"=>"required|string|email|max:100|unique:leads",
            "country_id"=>"required|exists:countries,id",
            "city_id"=>"required|exists:cities,id",
       ]);

       $user = Auth::user();
       $user_id = $user->id;

       $lead = new Lead();
       $lead->firstname = $request["firstname"];
       $lead->lastname = $request["lastname"];
       $lead->gender_id = $request["gender_id"];
       $lead->age = $request["age"];
       $lead->email = $request["email"];
       $lead->country_id = $request["country_id"];
       $lead->city_id = $request["city_id"];

       $lead->user_id = $user_id;
       $lead->save();

       return redirect(route("leads.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lead = Lead::findOrFail($id);
        return view("leads.show",["lead"=>$lead]);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lead = Lead::findOrFail($id);
        $genders = Gender::orderBy("name","asc")->get();
        $countries = Country::orderBy("name","asc")->where("status_id",3)->get();
        $cities = City::orderBy("name","asc")->where("status_id",3)->where("country_id",$lead->country_id)->get();
        return view("leads.edit")->with("lead",$lead)->with("genders",$genders)->with("countries",$countries)->with("cities",$cities);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "firstname"=>"required|string|max:100",
            "gender_id"=>"required|exists:genders,id",
            "age" => "required|integer|min:13|max:45",
            "email"=>"required|string|email|max:100|unique:leads,email,".$id,
            "country_id"=>"required|exists:countries,id",
            "city_id"=>"required|exists:cities,id",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

        

       $lead = Lead::findOrFail($id);
       $lead->firstname = $request["firstname"];
       $lead->lastname = $request["lastname"];
       $lead->gender_id = $request["gender_id"];
       $lead->age = $request["age"];
       $lead->email = $request["email"];
       $lead->country_id = $request["country_id"];
       $lead->city_id = $request["city_id"];
       $lead->user_id = $user_id;

        if($lead->isconverted()){
            return redirect()->back()->with('error',"Editing is disabled.");
        }
        $lead->save();

       

       return redirect(route("leads.index"));
    }

    public function mailbox(Request $request){
        // dd($request["cmpemail"]);        // "admin@gmail.com"
        // dd($request["cmpsubject"]);      // "very important" // app\Http\Controllers\leadsController.php:131
        // dd($request["cmpcontent"]);      // "hello" // app\Http\Controllers\leadsController.php:132
        
        // Method 1 (to MailBox)
        // $to = $request["cmpemail"];
        // $subject = $request["cmpsubject"];
        // $content = $request["cmpcontent"];
        // Mail::to($to)->send(new MailBox($subject,$content));
        // Mail::to($to)->cc("admin@dlt.com")->bcc("info@dlt.com")->send(new MailBox($subject,$content));

        // =>Usng Jog Method 1 (to MailBox)
        // dispatch(new MailBoxJob($to,$subject,$content));
        // MailBoxJob::dispatch($to,$subject,$content);

        // =>Method 2 (to LeadMailBox)
        // $data["to"] = $request["cmpemail"];
        // $data["subject"] = $request["cmpsubject"];
        // $data["content"] = $request["cmpcontent"];

        $data = [
            "to" => $request["cmpemail"],
            "subject" => $request["cmpsubject"],
            "content" => $request["cmpcontent"]
        ];
        
        // Mail::to($data["to"])->send(new LeadMailBox($data));
        dispatch(new LeadMailBoxJob($data));

        return redirect()->back();
    }

    public function quicksearch(Request $request){
        $leads = "";

        if($request->keyword != ""){
            $leads = Lead::where("regnumber","LIKE","%".$request->keyword."%")->get();
        }
        return response()->json(["datas"=>$leads]);
    }

    public function converttostudent($id){
        $lead = Lead::findOrFail($id);
        $lead->converttostudent();

        session()->flash("success","Pipe Successfully");
        return redirect()->back();
    }
}
