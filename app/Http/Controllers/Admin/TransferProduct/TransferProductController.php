<?php

namespace App\Http\Controllers\Admin\TransferProduct;

use App\Http\Controllers\Controller;
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

        $product = Product::find($request->product_id);

        $product_details = ProductDetails::where(['product_id' => $request->product_id, 'branch_id' => Auth::guard('admin')->user()->branch_id])->first();
        // return [$request->all(), $product_details];
        if ($request->quantity > $product_details->quantity) {
            toastr()->error(__('admin.warehouse_warehouse_not_enough') . __('admin.warehouse_warehouse_current_quantity') . ': ' . $product_details->quantity);
            return redirect()->back();
        }
        $product_details->quantity = $product_details->quantity - $request->quantity;
        $product_details->save();
        //return $product_details;
        TransferProduct::create([
            'product_id' => $request->product_id,
            'from_branch' => $request->from_branch,
            'to_branch' => $request->to_branch,
            'quantity' => $request->quantity,
            'done_by' => Auth::guard('admin')->id(),
        ]);
        $date = Carbon::today()->format('y-m-d');
        WarehouseLog::create([
            'date' => $date,
            'product_id' => $request->product_id,
            'branch_id' => $request->from_branch,
            'company_id' => $product->company_id,
            'warehouse_id' => $request->warehouse_id,
            'quantity' => $request->quantity,
            'dispatch_ref_no' => $request->dispatch_ref_no ?? '-1',
            'operation_id' => $request->operation_id,
            'notes' => $request->notes,
            'date' => Carbon::today()->format('y-m-d'),
            'added_by' => Auth::guard('admin')->user()->name
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
