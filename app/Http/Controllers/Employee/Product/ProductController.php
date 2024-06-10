<?php

namespace App\Http\Controllers\Employee\Product;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\WarehouseOperations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:employee-warehouse-show-products,employee'], ['only' => ['index']]);
    }
    public function index()
    {
        //
        $employee = Employee::where('id', Auth::guard('employee')->id())->first();
        $data = ProductDetails::where('branch_id', Auth::guard('employee')->user()->branch_id)->get();
        $products = Product::get();
        $operations = WarehouseOperations::get();
        // return Employee::where('id',Auth::id())->first();
        return view('employee.products.index', compact('data', 'products', 'operations'));
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
        //return $request->quantity;
        $employee = Auth::guard('employee')->user();
        ProductDetails::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'branch_id' => $employee->branch_id,
        ]);
        return redirect()->back();
    }


    public function productImportExport(Request $request)
    {
        //
        return $request->all();
        // $employee=Employee::where('id',Auth::guard('employee')->id())->first();
        // ProductDetails::create([
        //     'product_id'=>$request->product_id,
        //     'quantity'=>$request->quantity,
        //     'branch_id'=>$employee->branch_id,
        // ]);
        // return redirect()->back();
    }
    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
