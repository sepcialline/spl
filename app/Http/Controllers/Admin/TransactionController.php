<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Rider;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Helpers\ShipmentHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:admin-Transaction-Collect-Rider-Cash'], ['only' => ['collectRiderCash', 'collectCashRider']]);
        $this->middleware(['permission:admin-Transaction-Withdrawal-From-Merchant'], ['only' => ['WithdrawalMerchant', 'MerchantWithdrawal']]);
        $this->middleware(['permission:admin-Transaction-Pay-To-Merchant'], ['only' => ['getPayToTheMerchant', 'payToTheMerchant']]);
        $this->middleware(['permission:admin-Transaction-Withdrwal-Bank'], ['only' => ['WithdrawalBank', 'BankWithdrawal']]);
    }


    public function collectRiderCash()
    {
        $data['sum'] = 0;
        $date_from = Carbon::today()->format('Y-m-d');
        $date_to = Carbon::today()->format('Y-m-d');

        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('Y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('Y-m-d');
        }


        $data['from'] = $date_from;
        $data['to'] = $date_to;
        $data['riders'] = Rider::select('id', 'name')->get();

        if (request()->input('action') == 'search_action') {
            $query = Payment::query()->whereBetween('date', [$date_from, $date_to]);

            $request = request();

            $all_payments = ShipmentHelper::searchPayments($request, $query);

            $data['payments'] = $all_payments
                // ->where('status_id', 3)
                ->where('payment_method_id', 1)
                ->where('is_rider_has', 1)
                ->where('deleted_at', Null)
                ->with('shipment')
                ->get();

            $data['sum'] = Payment::whereIn('id', $data['payments']->pluck('id'))->sum('amount');

            $data['sum_expenses'] = Expense::whereBetween('date', [$date_from, $date_to])
                ->where('rider_id', Request()->rider_id)
                ->where('payment_type', 1)
                ->sum('value');

            $data['cod'] =  $data['sum'] -  $data['sum_expenses'];
            // ->select('id', 'shipment_no', 'shipment_refrence', 'is_split_payment', 'rider_should_recive')
            // foreach ($data['shipments'] as $shipment) {
            //     $data['sum'] += Payment::where('is_rider_has', 1)->where('shipment_id', $shipment->id)->sum('amount');
            // }
        }


        return view('admin.transactions.collect_rider_cash', $data);
    }

    public function collectCashRider(Request $request)
    {
        $data['payments'] = Payment::whereIn('id', $request->payments)->select('id', 'is_rider_has', 'updated_by', 'shipment_id')->get();

        $data['shipments'] = Shipment::whereIn('id', $data['payments']->pluck('shipment_id'))->get();

        $data['payments']->each->update([
            'is_rider_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('admin')->user()->name
        ]);

        $data['shipments']->each->update([
            'is_rider_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('admin')->user()->name
        ]);
        return response()->json(['code' => 200]);
    }

    public function WithdrawalMerchant()
    {
        $date_from = Carbon::today()->format('y-m-d');
        $date_to = Carbon::today()->format('y-m-d');

        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }


        $data['from'] = $date_from;
        $data['to'] = $date_to;
        $data['vendors'] = VendorCompany::select('id', 'name')->get();

        if (request()->input('action') == 'search_action') {
            $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to]);

            $request = request();

            $all_shipments = ShipmentHelper::searchShipment($request, $query);

            $data['shipments'] = $all_shipments
                ->where('status_id', 3)
                ->where('is_rider_has', 0)
                ->where('is_vendor_has', 1)
                ->where('deleted_at', Null)
                ->get();

            $sum = 0;
            foreach ($data['shipments'] as $shipment) {
                if ($shipment->is_split_payment == 0) {
                    $sum =  $sum + $shipment->specialline_due;
                } else {
                    $cash_amount = Payment::where('shipment_id', $shipment->id)->where('payment_method_id', 1)->amount;
                    $bank_amount = Payment::where('shipment_id', $shipment->id)->where('payment_method_id', 2)->amount;
                    // $vendor_amount = Payment::where('shipment_id',$shipment->id)->where('payment_method_id',3)->amount;
                    $sum = $sum + ($shipment->specialline_due - ($cash_amount + $bank_amount));
                }
            }

            $data['sum'] = $sum;
        }


        return view('admin.transactions.withdrawal_vendor', $data);
    }

    public function MerchantWithdrawal(Request $request)
    {
        $data['shipments'] = Shipment::whereIn('id', $request->payments)->get();

        $data['shipments']->each->update([
            'is_vendor_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('admin')->user()->name
        ]);

        foreach ($data['shipments'] as $shipment) {
            $data['payments'] = $shipment->payments->each->update([
                'is_vendor_has' => 0,
                'is_spl_get_due' => 1,
                'updated_by' => Auth::guard('admin')->user()->name
            ]);
        }

        return response()->json(['code' => 200]);
    }

    public function getPayToTheMerchant()
    {
        $data['vendors'] = VendorCompany::where('status', 1)->select('id', 'name')->get();

        // $date_from = Carbon::today()->format('Y-m-d');
        $date_to = Carbon::today()->format('Y-m-d');

        // if (request()->date_from) {
        //     $date_from = Carbon::parse(request()->date_from)->format('Y-m-d');
        // }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('Y-m-d');
        }

        $query = Payment::query();

        $request = request();
        $data['sum'] = 0;
        // $all_payments = ShipmentHelper::searchPayments($request, $query);





        // $data['from'] = $date_from;
        $data['to'] = $date_to;


        $data['shipments']  = Payment::where('company_id', $request->company_id)->where('is_vendor_get_due', 0)->whereDate('date', '<=', Carbon::parse($date_to)->format('Y-m-d'))->get();

        // $data['shipments'] = $all_payments->whereBetween('date', [$date_from, $date_to])
        // ->where('is_vendor_get_due', 0)
        // ->get();

        foreach ($data['shipments'] as $payment) {
            $data['sum'] = $data['sum'] + $payment->due_amount;
        }

        return view('admin.transactions.pay_to_murchant', $data);
    }

    public function payToTheMerchant(Request $request)
    {

        $data['payments'] = Payment::whereIn('id', $request->payments)->get();

        $data['payments']->each->update([
            'is_vendor_get_due' => 1,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('admin')->user()->name
        ]);


        foreach ($data['payments'] as $payment) {
            $data['shipment'] = $payment->shipment->update([
                'is_vendor_get_due' => 1,
                'is_spl_get_due' => 1,
                'updated_by' => Auth::guard('admin')->user()->name
            ]);
        }

        return response()->json(['code' => 200]);
    }


    public function WithdrawalBank()
    {
        $data['sum'] = 0;
        $date_from = Carbon::today()->format('y-m-d');
        $date_to = Carbon::today()->format('y-m-d');

        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }


        $data['from'] = $date_from;
        $data['to'] = $date_to;
        $data['vendors'] = VendorCompany::select('id', 'name')->get();

        if (request()->input('action') == 'search_action') {
            $query = Payment::query()->whereBetween('date', [$date_from, $date_to]);

            $request = request();

            $all_payments = ShipmentHelper::searchPayments($request, $query);

            $data['payments'] = $all_payments
                ->where('payment_method_id', 2)
                ->where('is_bank_has', 1)
                ->where('deleted_at', Null)
                ->with('shipment')
                ->get();

            $data['sum'] = Payment::whereIn('id', $data['payments']->pluck('id'))->sum('amount');
        }
        return view('admin.transactions.withdrawal_bank', $data);
    }

    public function BankWithdrawal(Request $request)
    {
        $data['payments'] = Payment::whereIn('id', $request->payments)->get();

        $data['shipments'] = Shipment::whereIn('id', $data['payments']->pluck('shipment_id'))->get();

        $data['payments']->each->update([
            'is_bank_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('admin')->user()->name
        ]);

        $data['shipments']->each->update([
            'is_bank_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('admin')->user()->name
        ]);
        return response()->json(['code' => 200]);
    }
}
