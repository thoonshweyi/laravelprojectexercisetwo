<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function expired(){
        return view("subscriptions.expired");
    }
}
