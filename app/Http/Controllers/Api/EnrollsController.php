<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Enroll;

class EnrollsController extends Controller
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
    public function dashboard(){
        $enrolls = Enroll::with(['post','user',"stage"])->get();
        $totalenrolls = $enrolls->count();

        $stages = [
            "Approved" => $enrolls->where("stage_id",1)->count(),
            "Pending" => $enrolls->where("stage_id",2)->count(),
            "Rejeted" => $enrolls->where("stage_id",3)->count(),
        ];

        $percenages = [];

        foreach($stages as $key=>$stage){
            $percenages[$key] = [
                'count' => $stage,
                'percentage' => $totalenrolls > 0 ? round(($stage/$totalenrolls) * 100,2) :0,
            ];
        }

        return response()->json([
            'totalenrolls' => $totalenrolls,
            'percentages'=> $percenages
        ]);
    }
}
