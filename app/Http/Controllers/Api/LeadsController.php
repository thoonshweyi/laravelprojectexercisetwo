<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lead;

class LeadsController extends Controller
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
        $totalleads = Lead::count();
        $convertedleads = Lead::where('converted',1)->count();
        $unconvertedleads = $totalleads - $convertedleads;

        $leadsources = [
            "Total Leads" => $totalleads,
            "Converted Leads" => $convertedleads,
            "Unconverted Leads" => $unconvertedleads,
        ];

        return response()->json([
            "leadsources" => $leadsources
        ]);

    }
}
