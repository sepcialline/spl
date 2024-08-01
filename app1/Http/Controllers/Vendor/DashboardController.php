<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\JounalType;
use Illuminate\Http\Request;
use App\Helpers\ShipmentHelper;
use App\Models\AccountingEntries;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ->select('product_details.*',DB::raw("SUM('product_details.quantity')"))
        $data['products'] =
           ProductDetails::selectRaw('product_details.*,SUM(quantity) as qty')
            ->groupBy('product_details.product_id')
            ->whereHas('product', function ($q) {
                $q->where('company_id', Auth::guard('vendor')->user()->company_id);
            })
            ->get();
        $data['delivered_shipments'] = Shipment::where('status_id', 3)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();
        $data['returned_shipments'] = Shipment::where('status_id', 9)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();
        $data['delayed_shipments'] = Shipment::where('status_id', 4)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();
        $data['canceled_shipments'] = Shipment::where('status_id', 6)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();

        // amount for vendor
        $query = Shipment::query();
        $request = request();

        $all_shipments = ShipmentHelper::searchPayments($request, $query);

        // $data['shipments'] = $all_shipments
        //     ->where('company_id',Auth::guard('vendor')->user()->company_id)
        //     ->whereIn('status_id', [3,9])
        //     // ->where('is_rider_has', 0)
        //     ->where('is_vendor_get_due', 0)
        //     ->where('deleted_at', Null)
        //     ->get();

        // foreach ($data['shipments'] as $shipment) {
        //     if ($shipment->is_split_payment == 0) {
        //         $data['sum'] =  $data['sum'] + $shipment->vendor_due;
        //     } else {
        //         $to_vendor = 0;
        //         $payment = Payment::where('shipment_id', $shipment->id)->where('is_split', 1)->where('payment_method_id', 3)->where('is_vendor_get_due', 0)->first();
        //         $to_vendor = $payment->amount ?? 0;
        //         $data['sum'] = $data['sum'] + ($shipment->vendor_due - $to_vendor);
        //     }
        // }

        $data['shipments_vendor_due'] = $all_shipments
            ->where('status_id', 3)
            ->where('company_id',Auth::guard('vendor')->user()->company_id)
            // ->where('is_rider_has', 0)
            // ->where('is_vendor_get_due', 0)
            ->where('deleted_at', Null)
            ->get();

        $data['sum'] = Payment::whereIn('shipment_id',  $data['shipments_vendor_due']->pluck('id'))->sum('due_amount');

        //latest 5 transiction

        $query =
            AccountingEntries::query()->where('account_number', Auth::guard('vendor')->user()->company->account_number)->where('debit', '!=', 0);

        $data['journal_numbers'] = $query->orderBy('id','desc')->take(8)->get();
        $data['journals'] = array();
        foreach ($data['journal_numbers'] as $number) {

            $credit = AccountingEntries::where('number', $number->number)->where('credit', '!=', 0)->first();
            $debit = AccountingEntries::where('number', $number->number)->where('debit', '!=', 0)->first();
            $currency = __('admin.currency');
            $data['journals'][] = [
                'number' => $number->number,
                'type' => JounalType::where('id', $number->journal_type_id)->first(),
                'debit' => "$debit->debit  $currency",
                'statment' => $number->statment,
                'date' => $number->transaction_date
            ];
        }

        return view('vendor.dashboard.dashboard', $data);
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
