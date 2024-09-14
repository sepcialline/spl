<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\VendorCompany;
use App\Models\Warehouse;
use App\Models\WarehouseLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:admin-Product-show-page', ['only' => ['index']]);
        $this->middleware('permission:admin-Product-add', ['only' => ['create','store']]);
        $this->middleware('permission:admin-Product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin-Product-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['companies'] = VendorCompany::where('status',1)->where('has_stock',1)->get();
        $data['branchs']= Branches::where('is_main',0)->where('status',1)->get();

        $query = Product::query()->where('status',1);

        if(Request()->company_id && Request()->company_id != 0){
            $query->where('company_id', Request()->company_id);
        }

        if(Request()->branch_id && Request()->branch_id != 0){
            $query->where('branch_id', Request()->branch_id);
        }


        $data['data'] = $query->orderBy('branch_id', 'ASC')->get();

        return view('admin.products.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $companies = VendorCompany::where('has_stock',1)->get();
        return view('admin.products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $product = new Product();
        $product->name = ['en' => $request->product_name_en, 'ar' => $request->product_name_ar];
        $mytime = Carbon::now();
        $mytime_s = 'prod-qr-' . $mytime->toDateTimeString();
        $product->code = $mytime_s; //$request->product_code;
        $product->company_id = $request->company_id;
        $product->save();
        $product_l = Product::latest()->first();
        ProductDetails::create([
            'product_id' => $product_l->id,
            'branch_id' => Auth::guard('admin')->user()->branch_id,
            'quantity' => 0
        ]);
        $date = Carbon::today()->format('y-m-d');
        WarehouseLog::create([
            'date' => $date,
            'product_id' => $product_l->id,
            'company_id' => $request->company_id,
            'branch_id' => Auth::guard('admin')->user()->branch_id,
            'warehouse_id' => $request->warehouse_id,
            'quantity' => 0,
            // 'dispatch_ref_no' => $request->dispatch_ref_no ?? '-1',
            'dispatch_ref_no' => '-',
            'operation_id' => 5,
            'date' => Carbon::today()->format('y-m-d'),
            'added_by' => Auth::guard('admin')->id()
        ]);
        toastr()->success(__('admin.msg_success_add'));
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
        $companies = VendorCompany::get();
        $product = Product::find($id);
        return view('admin.products.update', compact('companies', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function updateStatus(Request $request, string $id)
    {
        //
        $warehouse = Warehouse::find($id);
        $warehouse->status = $request->status;
        $warehouse->save();
        return response(['req' => $request, 'id' => $id], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Product::find($id)->delete();
        return response(['success' => 1], 200);
    }

    public function approved(Request $request){
        $product = Product::find($request->id)->update(['status'=>1]);
    }
}
