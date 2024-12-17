<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CitiesController extends Controller
{
    public function index()
    {
            // $this->authorize('view',City::class);
        $cities = City::where(function($query){
            if($getname = request("filtername")){
                $query->where("name","LIKE","%".$getname."%");
            }
        })->get();
        // dd($cities);

        $countries = Country::where("status_id",3)->orderBy("name","asc")->get();
        $statuses = Status::whereIn("id",[3,4])->get();
        return view("cities.index",compact("cities","countries","statuses"));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|unique:cities,name",
        ]);

       $user = Auth::user();
       $user_id = $user->id;

       $city = new City();
            $this->authorize('create',$citiy);
       $city->name = $request["name"];
       $city->slug = Str::slug($request["name"]);
       $city->country_id = Str::slug($request["name"]);
       $city->user_id = $user_id;

       $city->save();
       return redirect(route("cities.index"));
    }

    public function edit($id){
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "name" => "required|unique:cities,name,".$id,
        ]);

       $user = Auth::user();
       $user_id = $user['id'];

       $city = City::findOrFail($id);
            $this->authorize('edit',$citiy);
       $city->name = $request["name"];
       $city->slug = Str::slug($request["name"]);
       $city->user_id = $user_id;

       $city->save();
       return redirect(route("cities.index"));
    }


    public function destroy(string $id)
    {
        $city = City::findOrFail($id);
                $this->authorize('delete',$citiy);
        $city->delete();
        return redirect()->back();
    }

    public function bulkdeletes(Request $request)
    {
        try{
            $getselectedids = $request->selectedids;
            City::whereIn("id",$getselectedids)->delete();
            return response()->json(["success"=>"Selected data have been deleted successfully"]);
        }catch(Exception $e){
            Log::error($e->getMEssage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }
}
