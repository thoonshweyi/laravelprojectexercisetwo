<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function dashboard(){
        // $user_id = Auth::id();
        // $contacts = Contact::where('user_id',$user_id)->latest()->take(5)->get(['id','firstname','lastname','birthday','relative_id']);

        // need to check
        $contacts = Contact::latest()->take(5)->get(['id','firstname','lastname','birthday','relative_id']);
        $datas = $contacts->map(function($contact){
            return [
                'firstname' => $contact->firstname,
                'lastname' => $contact->lastname,
                'birthday' => $contact->birthday,
                'relative' => $contact->relative_id ?$contact->relative->name : 'N/A',
            ];
        });
   
        return response()->json($datas);
    }
}
