<?php

namespace App\Http\Controllers\Employee\ProductDetails;

use App\Http\Controllers\Controller;
use App\Models\ProductDetails;
use App\Models\WarehouseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDetailsController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:employee-warehouse-transfer-request|employee-warehouse-delivered_quantity,employee'], ['only' => ['store']]);
    }
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
        $quantity=0;
        if($request->operation_id==1 ||$request->operation_id==3 ){
            $quantity=$request->quantity + $request->total_import_export;
          //  return $quantity;
        }else if($request->operation_id==2){
            $quantity=$request->quantity - $request->total_import_export;
           // return $quantity;
        }
        ProductDetails::updateOrcreate(['product_id'=>$request->product_id,'branch_id'=>$request->branch_id],[
            'product_id'=>$request->product_id,
            'branch_id'=>$request->branch_id,
            'quantity'=>$quantity
        ]);
        WarehouseLog::create([
            'product_id'=>$request->product_id,
            'branch_id'=>$request->branch_id,
            'quantity'=>$quantity,
            'dispatch_ref_no'=>$request->dispatch_ref_no,
            'operation_id'=>$request->operation_id,
            'added_by'=>Auth::guard('employee')->id()
        ]);
        toastr()->success(__("admin.msg_success_add"));
        return redirect()->back();
    }
    public function deliver(Request $request)
    {
        $product_details=ProductDetails::find($request->id);
        $product_details->delivered=1;
        $product_details->save();
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
