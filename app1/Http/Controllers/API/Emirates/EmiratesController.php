<?php

namespace App\Http\Controllers\API\Emirates;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Emirates;
use Illuminate\Http\Request;

class EmiratesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $emirates = Emirates::get();
        $message = ['success' => 0, 'message' => 'Success'];
        return response(compact('emirates',  'message'), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
        $cities = Cities::get(); // where('emirate_id', $id)->get();
        $message = ['success' => 0, 'message' => 'Success'];
        return response(compact('cities', 'message'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
}
