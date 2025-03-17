<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Leave;
class LeavesController extends Controller
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
        $leaves = Leave::all();

        $datas = [
            "totalleaves" => $leaves->count(),
            "approved" => $leaves->where("stage_id",1)->count(),
            "pending" => $leaves->where("stage_id",2)->count(),
            "rejeted" => $leaves->where("stage_id",3)->count(),
        ];

        return response()->json($datas);
    }
}
