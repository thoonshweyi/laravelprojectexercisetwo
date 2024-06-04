<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Status;
use App\Models\Relative;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

use App\Notifications\ContactEmailNotify;

class ContactsController extends Controller
{
    public function index()
    {
        // $data["contacts"] = Contact::paginate(5);
        $data["contacts"] = Contact::filteronly()->searchonly()->zafirstname()->paginate(5)->withQueryString();
        $relatives = Relative::orderBy("id","asc")->pluck("name","id")->prepend("Choose relative","");
        return view("contacts.index",compact("relatives"),$data);
    }
    // pluck() automatically sort a-zs


    public function store(Request $request)
    {
        $this->validate($request,[
            "firstname" => "required|min:3|max:50",
            "lastname"=>"max:50",
            "birthday"=>"nullable",
            "relative_id"=>"nullable"
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $contact = new Contact();
       $contact->firstname = $request["firstname"];
       $contact->lastname = $request["lastname"];
       $contact->birthday = $request["birthday"];
       $contact->relative_id = $request["relative_id"];
       $contact->user_id = $user_id;

       $contact->save();

        $contactdata = [
            "firstname" => $contact->firstname,
            "lastname" => $contact->lastname,
            "birthday" => $contact->birthday,
            "relative" => $contact->relative["name"],
            "url"=>url("/")
        ];
        Notification::send($user,new ContactEmailNotify($contactdata));

       session()->flash("success","New Contact Created");
       return redirect(route("contacts.index"));
    }
    
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "firstname" => "required|min:3|max:50",
            "lastname"=>"max:50",
            "birthday"=>"nullable",
            "relative_id"=>"nullable"
        ]);

        $user = Auth::user();
        $user_id = $user["id"];

        $contact = Contact::findOrFail($id);
        $contact->firstname = $request["firstname"];
        $contact->lastname = $request["lastname"];
        $contact->birthday = $request["birthday"];
        $contact->relative_id = $request["relative_id"];
        $contact->user_id = $user_id;
        $contact->save();

        session()->flash("success","Update Successfully");
        return redirect(route("contacts.index"));
    }


    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        session()->flash("info","Delete Successfully");
        return redirect()->back();
    }
}
