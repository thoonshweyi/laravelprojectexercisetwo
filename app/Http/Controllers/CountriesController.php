<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CountriesController extends Controller
{
    public function index()
    {
        // http://127.0.0.1:8000/countries?filtername=mm
        // dd(request("filtername")); // mm

        $countries = Country::where(function($query){
                if($getname = request("filtername")){
                    $query->where("name","LIKE","%".$getname."%");
                }
        })->paginate(5);
        // dd($countries);
        return view("countries.index",compact("countries"));
    }
    // request() - get the request form value

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|unique:countries,name",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $country = new Country();
       $country->name = $request["name"];
       $country->slug = Str::slug($request["name"]);
       $country->user_id = $user_id;

       $country->save();
       return redirect(route("countries.index"));
    }


    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "name" => "required|unique:countries,name,".$id,
        ]);

       $user = Auth::user();
       $user_id = $user['id'];

       $country = Country::findOrFail($id);
       $country->name = $request["name"];
       $country->slug = Str::slug($request["name"]);
       $country->user_id = $user_id;

       $country->save();
       return redirect(route("countries.index"));
    }


    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        return redirect()->back();
    }
}
