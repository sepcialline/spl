<?php

namespace App\Http\Controllers\Employee\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TransferRequest;
use App\Models\Vendor;
use App\Models\VendorCompany;
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
        $data=WarehouseTransfer::where('branch_id', Auth::guard('employee')->user()->branch_id)->get();
        return view('employee.transfer.index', compact('data'));
    }
    public function getVendorProducts(Request $request)
    {
        //
        $data=Product::where('company_id', $request->id)->select("name", "id")->get();
        return $data;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products=Product::get();
        $vendors=VendorCompany::get();
        return view('employee.transfer.create',compact('products','vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //return [$request->all(), Auth::guard('employee')->user()->branch_id];
        TransferRequest::create(
            [
                'product_id'=>$request->product_id,
                'from_branch'=>Auth::guard('employee')->user()->branch_id,
                'quantity'=>$request->quantity,
                'requested_by'=>Auth::guard('employee')->id()
            ]
        );
        // WarehouseTransfer::create([
        //     'branch_id'=>Auth::guard('employee')->user()->branch_id,
        //     'product_id'=>$request->product_id,
        //     'company_id'=>Product::where('id',$request->product_id)->first()->company_id,
        //     'quantity'=>$request->quantity,

        // ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
