<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
class StudentsController extends Controller
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
        $totalstudents= Student::count();
        $activestudents= Student::where('status_id',1)->count();
        $agegroups = [
            "Under 18" => Student::where("age","<",18)->count(),
            "18-25" => Student::whereBetween("age",[18,25])->count(),
            "26-30" => Student::whereBetween("age",[26,30])->count(),
            "31-35" => Student::whereBetween("age",[31,35])->count(),
            "36-50" => Student::whereBetween("age",[36,50])->count(),
            "Above 50" => Student::where("age",">",50)->count(),
        ];

        $genders = [
            'Male' => Student::where("gender_id",1)->count(),
            'Female' =>Student::where("gender_id",2)->count(),
            'Other' => Student::whereNotIn("gender_id",[1,2])->count(),
        ];

        return response()->json([
             "totalstudents" => $totalstudents,
             "activestudents" => $activestudents,
             "agegroups" => $agegroups,
             "genders" => $genders
        ]);

   }
}
