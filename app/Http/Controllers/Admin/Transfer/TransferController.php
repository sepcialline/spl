<?php

namespace App\Http\Controllers\Admin\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\ProductDetails;
use App\Models\TransferRequest;
use App\Models\WarehouseTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=TransferRequest::get();
        return view('admin.transfer.index', compact('data'));
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
        $transfer=TransferRequest::find($id);
        $branches=Branches::get();
        //return [$transfer];
        $products=ProductDetails::where(['product_id'=>$transfer->product_id])->get();
        return view('admin.transfer.show',compact('transfer','products','branches'));
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
        $product_details=WarehouseTransfer::find($id);
        return response( $product_details);
        $product_details->is_admin_accept=$request->is_admin_accept;
        $product_details->is_branch_accept=$request->is_branch_accept;
        $product_details->save();
        return response([$request->is_admin_accept, $id],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
