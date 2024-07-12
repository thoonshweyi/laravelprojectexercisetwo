<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Package;
use App\Models\UserPoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    public function index(){
        $user = Auth::user();
        $user_id = $user->id;
        $carts = Cart::where("user_id",$user_id)->get();
        $totalcost = $this->gettotalcost($carts);
        return view("carts.index",compact("carts","totalcost"));
    }

    private function gettotalcost($carts){
        $totalcost = 0;

        foreach($carts as $cart){
            $totalcost += $cart->quantity * $cart->price;
        }
        return $totalcost;
    }

    public function add(Request $request){
        $user_id = auth()->id();

        Cart::updateOrCreate([
            "user_id"=>$user_id,
            "package_id"=>$request->package_id,
            "quantity"=>$request->input("quantity"),
            // "quantity"=>\DB::raw('quantity +'.$request->input("quantity")),
            "price"=>$request->input("price")
        ]);
        return response()->json(["message"=>"Product added to cart successfully"]);
    }

    public function remove(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $packageid = $request->packageid;

        $cart = Cart::where("user_id",$user_id)->where("package_id",$packageid)->first();
        $cart->delete();

        $usrcarts = Cart::where("user_id",$user_id)->get();
        $totalcost = $this->gettotalcost($usrcarts);

        return response()->json(["message"=>"Removed from cart successfully","totalcost"=>$totalcost]);
    }

    public function paybypoints(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $carts = Cart::where("user_id",$user_id)->get();
        $isextend = false;

        $totalcost = $carts->sum(function($cart){
            return $cart->price * $cart->quantity;
        });

        $packageid = $request->packageid;
        $package = Package::findOrFail($packageid);
        $userpoints = UserPoint::where("user_id",$user_id)->first();

        if($userpoints && $userpoints->points >= $totalcost){
            // Acceptable Package Buying

            // Deduct Points
            $userpoints->points -= $totalcost;
            $userpoints->save();

            if($user->subscription_expires_at >= Carbon::now()){
                // Extend Package
                $isextend = true;

                $user->package_id = $packageid;
                $user->subscription_expires_at = Carbon::parse($user->subscription_expires_at)->addDay($package->duration);
                $user->save();


            }else{
                // Renew Package
                $isextend = false;

                $user->package_id = $packageid;
                $user->subscription_expires_at = Carbon::now()->addDay($package->duration);
                $user->save();


            }
            // create invoice

            // remove cart
            Cart::where("user_id",$user_id)->delete();
            // $cart->each->delete(); // each is default method
            

            return response()->json(["message"=> $isextend ?  "Package Extended Successfully": "New Package Added"]);
        }
        
    
        // Unacceptable Package Buying
        return response()->json(["message"=>"Insufficient Points"],400);


    }

    public function paywithcash(Request $request){

    }


    public function paywithwallet(Request $request){

    }

    public function paywithvisa(Request $request){

    }
}

// 10.May.2024    silver package | 10.June.2024    silver package (expire)
// =Buying package
// 11.June.2024   silver package | 11.July.2024    silver package (new expire)

// 10.May.2024    silver package | 10.June.2024    silver package (expire)
// =Buying package
// 20.May.2024   silver package  | 20.July.2024    silver package (new expire)
// Actual Expire Date = 30.July.2024


