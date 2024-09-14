<?php

namespace App\Http\Controllers\Employee\Product;

use App\Events\AddProductEvent;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Warehouse;
use App\Models\WarehouseLog;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\DB;
use App\Models\WarehouseOperations;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Notifications\AddProductNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:employee-warehouse-show-products,employee'], ['only' => ['index']]);
    }
    public function index()
    {
        //
        $data['companies'] = VendorCompany::where('status', 1)->where('branch_id', Auth::guard('employee')->user()->branch_id)->where('has_stock', 1)->get();

        $query = Product::query()->where('status', 1)->where('branch_id', Auth::guard('employee')->user()->branch_id);

        if (Request()->company_id && Request()->company_id != 0) {
            $query->where('company_id', Request()->company_id);
        }



        $data['products'] = $query->orderBy('company_id', 'ASC')->get();
        return view('employee.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $companies =  VendorCompany::where('status', 1)->where('branch_id', Auth::guard('employee')->user()->branch_id)->where('has_stock', 1)->get();
        return view('employee.products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {

            $product = new Product();
            if ($request->file()) {

                if ($request->hasFile('image')) {
                    $image_name = $request->image != null ? time() . '_' . $request->image->getClientOriginalName() : $request->logo_en;
                    //$data->	logo_en=$image_name;
                    $request->image->move(public_path('build/assets/img/uploads/products'), $image_name);
                    $product->image = $image_name;
                }
            }


            $product->name = ['en' => $request->product_name_en, 'ar' => $request->product_name_ar];
            $product->code = $request->product_code;
            $product->company_id = $request->company_id;
            $product->status = 1;
            $product->created_by = Auth::guard('employee')->user()->name;
            $product->branch_id = Auth::guard('employee')->user()->branch_id;
            $product->price = $request->price;
            $product->save();

            $company = VendorCompany::where('id', $request->company_id)->first();
            WarehouseLog::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'product_id' =>  $product->id,
                'company_id' => $request->company_id,
                'branch_id' =>  $company->branch_id,
                'warehouse_id' => Warehouse::where('branch_id', $company->branch_id)->first()->id,
                'quantity' => 0,
                'dispatch_ref_no' => '',
                'operation_id' => 5, // add item
                'notes' => 'اضافة منتج ',
                'date' => Carbon::today()->format('Y-m-d'),
                'added_by' => Auth::guard('employee')->user()->name,
            ]);

            // event(new AddProductEvent('This is add product data'));


            // $data = [
            //     'title' => 'طلب اضافة منتج جديد',
            //     'number' => '',
            //     'created_by' => Auth::guard('employee')->user()->name,
            //     'company' => $company->name
            // ];

            // $admins = Admin::get();
            // foreach ($admins as $admin) {
            //     $admin->notify(new AddProductNotification($data));
            // }
        });

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
        $companies = VendorCompany::where('status', 1)->where('branch_id', Auth::guard('employee')->user()->branch_id)->where('has_stock', 1)->get();
        $product = Product::find($id);
        return view('employee.products.update', compact('companies', 'product'));
    }

    public function updateproducts(Request $request)
    {
        DB::transaction(function () use ($request) {

            $product = Product::where('id', $request->id)->first();
            if ($request->file()) {

                if ($request->hasFile('image')) {
                    $image_name = $request->image != null ? time() . '_' . $request->image->getClientOriginalName() : $request->logo_en;
                    //$data->	logo_en=$image_name;
                    $request->image->move(public_path('build/assets/img/uploads/products'), $image_name);
                    $product->update(['image' => $image_name]);
                }
            }
            $product->update([
                'name' => ['en' => $request->product_name_en, 'ar' => $request->product_name_ar],
                'code' => $request->product_code,
                'company_id' => $request->company_id,
                'status' => 1,
                'updated_by' => Auth::guard('employee')->user()->name,
                'branch_id' => Auth::guard('employee')->user()->branch_id,
                'price'=> $request->price,
            ]);



            // event(new AddProductEvent('This is add product data'));


            // $data = [
            //     'title' => 'طلب اضافة منتج جديد',
            //     'number' => '',
            //     'created_by' => Auth::guard('employee')->user()->name,
            //     'company' => $company->name
            // ];

            // $admins = Admin::get();
            // foreach ($admins as $admin) {
            //     $admin->notify(new AddProductNotification($data));
            // }
        });

        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
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

    public function products_import_export(Request $request)
    {

        DB::transaction(function () use ($request) {
            $warehouse = Warehouse::where('branch_id', Auth::guard('employee')->user()->branch_id)->first()->id;
            $details = ProductDetails::updateOrCreate(['product_id' => $request->product_id, 'branch_id' => Auth::guard('employee')->user()->branch_id, 'warehouse_id' => $warehouse], [
                'product_id' => $request->product_id,
                'branch_id' => Auth::guard('employee')->user()->branch_id,
                'warehouse' => $warehouse,
            ]);
            $operation = Null;
            if ($request->import_export == 1) { // import
                $details->update([
                    'quantity' => $details->quantity + $request->quantity,
                ]);
                $operation = 1; // import qty
            } else {
                $details->update([
                    'quantity' => $details->quantity - $request->quantity,
                ]);
                $operation = 2; // export qty
            }

            $company = VendorCompany::where('id', $request->company_id)->first();
            WarehouseLog::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'product_id' =>  $request->product_id,
                'company_id' => $request->company_id,
                'branch_id' =>  $company->branch_id,
                'warehouse_id' => $warehouse,
                'quantity' => $request->quantity,
                'dispatch_ref_no' => '',
                'operation_id' => $operation,
                'notes' => $request->products_notes,
                'date' => Carbon::today()->format('Y-m-d'),
                'added_by' => Auth::guard('employee')->user()->name,
            ]);
        });

        toastr()->success(__('admin.msg_success_update'));

        return redirect()->back();
    }
}
