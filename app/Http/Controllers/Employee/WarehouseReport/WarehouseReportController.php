<?php

namespace App\Http\Controllers\Employee\WarehouseReport;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Branches;
use App\Models\Shipment;
use App\Models\WarehouseLog;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Helpers\ShipmentHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WarehouseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branch = Auth::guard('employee')->user()->branch_id;
        $companies = VendorCompany::where('status',1)->where('has_stock',1)->where('branch_id',$branch)->get();
        $products = Product::where('branch_id',$branch)->get();
        $date_from = Carbon::today()->format('y-m-d');
        $date_to = Carbon::today()->format('y-m-d');
        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }
        $query = WarehouseLog::query()->whereBetween('date', [$date_from, $date_to])->where('branch_id', $branch);
        $from = $date_from;
        $to = $date_to;
        if (request()->company_id && request()->company_id != 0) {
            $query->where('company_id', request()->company_id);
        }
        if (request()->branch_id && request()->branch_id != 0) {
            $query->where('branch_id', request()->branch_id);
        }
        if (request()->product_id && request()->product_id != 0) {
            $query->where('product_id', request()->product_id);
        }
        if (request()->input('action') == 'report') {
            $query = $query->orderby('date', 'desc')->get();
            return  view('employee.warehouse_report.reports.warehouse_report', compact('companies', 'products', 'from', 'to', 'query'));
        } else {
            $query = $query->orderby('date', 'desc')->paginate(10);
            return view('employee.warehouse_report.index', compact('companies', 'products', 'from', 'to', 'query'));
        }
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
