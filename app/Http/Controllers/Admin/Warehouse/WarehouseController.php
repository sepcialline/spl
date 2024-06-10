<?php

namespace App\Http\Controllers\Admin\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-warehouse-show-page', ['only' => ['index']]);
        $this->middleware('permission:admin-warehouse-add', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-warehouse-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-warehouse-change-status', ['only' => ['updateStatus']]);
        $this->middleware('permission:admin-warehouse-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Warehouse::get();
        return view('admin.warehouse.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $branches = Branches::get();
        $emirates = Emirates::get();
        return view('admin.warehouse.create', compact('branches', 'emirates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Warehouse::create(
            [
                'warehouse_name' => ['en' => $request->warehouse_name_en, 'ar' => $request->warehouse_name_ar],
                'branch_id' => $request->branch_id
            ]
        );
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
        $branches = Branches::get();
        $emirates = Emirates::get();
        $warehouse = Warehouse::find($id);
        return view('admin.warehouse.update', compact('branches', 'emirates', 'warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $warehouse = Warehouse::find($id);
        $warehouse->warehouse_name = ['en' => $request->warehouse_name_en, 'ar' => $request->warehouse_name_ar];
        $warehouse->branch_id = $request->branch_id;
        $warehouse->save();
        return redirect()->back();
    }
    public function updateStatus(Request $request, string $id)
    {
        //
        $warehouse = Warehouse::find($id);
        //return response( $product_details);
        $warehouse->status = $request->status;
        $warehouse->save();
        return response([$request->is_admin_accept, $id], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Warehouse::find($id)->delete();
        return response(['success' => 1], 200);
    }
}
