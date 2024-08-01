<?php

namespace App\Http\Controllers\Employee\WarehouseReport;

use App\Helpers\ShipmentHelper;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\VendorCompany;
use App\Models\WarehouseLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WarehouseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return request();
        $companies = VendorCompany::get();
        $branches = Branches::get();
        $products = Product::get();
        $date_from = Carbon::today()->format('y-m-d');
        $date_to = Carbon::today()->format('y-m-d');
        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }
        $query = WarehouseLog::query()->whereBetween('date', [$date_from, $date_to]);
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
            return  view('employee.warehouse_report.reports.warehouse_report', compact('companies', 'branches', 'products', 'from', 'to', 'query'));
        } else {
            $query = $query->orderby('date', 'desc')->paginate(10);
            return view('employee.warehouse_report.index', compact('companies', 'branches', 'products', 'from', 'to', 'query'));
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
