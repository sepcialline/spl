<?php

namespace App\Http\Controllers\Admin\ProductDetails;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Warehouse;
use App\Models\WarehouseLog;
use App\Models\WarehouseOperations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDetailsController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:admin-Product-details-showPage', ['only' => ['index']]);
        $this->middleware('permission:admin-Product-details-import|admin-Product-details-export|admin-Product-details-adjust|admin-Product-details-transfer', ['only' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employee = Auth::guard('admin')->user(); //Employee::where('id',Auth::guard('admin')->id())->first();
        $data = ProductDetails::orderBy('id','desc')->paginate(10);
        // return $data;
        $products = Product::get();
        $operations = WarehouseOperations::get();
        $branches = Branches::where('id', '!=', Auth::user()->branch_id)->get();
        $warehouses = Warehouse::get();
        return view('admin.product_details.index', compact('data', 'products', 'operations', 'branches', 'warehouses'));
    }
    // Search Admins
    public function search(Request $request)
    {
        return $request->all();
        $result = Product::where('name', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('mobile', 'LIKE', '%' . $request->search . '%')->get();
        return ['results' => $result->all()];
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
        // return $request->all();
        $date = Carbon::today()->format('y-m-d');

        $d_quantity = 0;
        $s_quantity = 0;
        //import process
        if ($request->operation_id == 1 || $request->operation_id == 3) {
            $quantity = $request->quantity + $request->total_import_export;
        }
        //export process
        else if ($request->operation_id == 2) {
            $quantity = $request->quantity - $request->total_import_export;
        }
        //adjust
        else if ($request->operation_id == 3) {
            $quantity = $request->quantity;
        }
        //transfer new import into target branch
        else {

            return $request->all();
        }
        ProductDetails::updateOrcreate(['product_id' => $request->product_id], [
            'product_id' => $request->product_id,
            'branch_id' => $request->branch_id,
            'quantity' => $quantity
        ]);
        $product = Product::find($request->product_id);
        $date = Carbon::today()->format('y-m-d');
        WarehouseLog::create([
            'date' => $date,
            'product_id' => $request->product_id,
            'branch_id' => $request->branch_id,
            'company_id' => $product->company_id,
            'warehouse_id' => $request->warehouse_id,
            'quantity' => $request->total_import_export ?? $request->quantity,
            'dispatch_ref_no' => $request->dispatch_ref_no ?? '-1',
            'operation_id' => $request->operation_id,
            'notes' => $request->notes,
            'date' => $date,
            'added_by' => Auth::guard('admin')->id()
        ]);
        toastr()->success(__("admin.msg_success_add"));
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
