<?php

namespace App\Http\Controllers\Employee\TransferProduct;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\TransferProduct;
use App\Models\WarehouseLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $branches = Branches::get();
        $data = TransferProduct::get();
        return view('employee.transfer_product.index', compact('data', 'branches'));
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

        TransferProduct::create([
            'product_id' => $request->product_id,
            'from_branch' => $request->from_branch,
            'to_branch' => $request->to_branch,
            'quantity' => $request->quantity,
            'done_by' => Auth::guard('employee')->id(),
        ]);

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
        // return $request->all();
        $product_details = ProductDetails::where(['product_id' => $request->product_id, 'branch_id' => Auth::guard('employee')->user()->branch_id])->first();
        ProductDetails::updateOrcreate([
            'product_id' => $request->product_id, 'branch_id' => Auth::guard('employee')->user()->branch_id
        ], [
            'product_id' => $request->product_id,
            'branch_id' => Auth::guard('employee')->user()->branch_id,
            'quantity' => $product_details ? $product_details->quantity + $request->quantity : $request->quantity,
        ]);
        $product = Product::find($request->product_id);
        $date = Carbon::today()->format('y-m-d');
        WarehouseLog::create([
            'date' => $date,
            'product_id' => $request->product_id,
            'branch_id' => Auth::guard('employee')->user()->branch_id,
            'company_id' => $product->company_id,
            'warehouse_id' => $request->warehouse_id,
            'quantity' => $request->quantity,
            'dispatch_ref_no' => $request->dispatch_ref_no ?? '-1',
            'operation_id' => 6, //$request->operation_id,
            'added_by' => Auth::guard('employee')->user()->name
        ]);
        //return $product_details;
        $transfer_product = TransferProduct::find($id);
        $transfer_product->deliver_status = 1;
        $transfer_product->delivered_by = Auth::guard('employee')->id();
        $transfer_product->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
