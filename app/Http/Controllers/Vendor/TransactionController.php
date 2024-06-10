<?php

namespace App\Http\Controllers\Vendor;

use Carbon\Carbon;
use App\Models\Rider;
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
    public function collectRiderCash()
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
        $data['riders'] = Rider::where('branch_id',Auth::guard('employee')->user()->branch_id)->select('id', 'name')->get();

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
            // ->select('id', 'shipment_no', 'shipment_refrence', 'is_split_payment', 'rider_should_recive')
            // foreach ($data['shipments'] as $shipment) {
            //     $data['sum'] += Payment::where('is_rider_has', 1)->where('shipment_id', $shipment->id)->sum('amount');
            // }
        }


        return view('employee.transactions.collect_rider_cash', $data);
    }

    public function collectCashRider(Request $request)
    {
        $data['payments'] = Payment::whereIn('id', $request->payments)->select('id', 'is_rider_has', 'updated_by', 'shipment_id')->get();

        $data['shipments'] = Shipment::whereIn('id', $data['payments']->pluck('shipment_id'))->get();

        $data['payments']->each->update([
            'is_rider_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('employee')->user()->name
        ]);

        $data['shipments']->each->update([
            'is_rider_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('employee')->user()->name
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


        return view('employee.transactions.withdrawal_vendor', $data);
    }

    public function MerchantWithdrawal(Request $request)
    {
        $data['shipments'] = Shipment::whereIn('id', $request->payments)->get();

        $data['shipments']->each->update([
            'is_vendor_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('employee')->user()->name
        ]);

        foreach ($data['shipments'] as $shipment) {
            $data['payments'] = $shipment->payments->each->update([
                'is_vendor_has' => 0,
                'is_spl_get_due' => 1,
                'updated_by' => Auth::guard('employee')->user()->name
            ]);
        }

        return response()->json(['code' => 200]);
    }

    public function getPayToTheMerchant()
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
        $data['sum'] = 0;

        if (request()->input('action') == 'search_action') {
            $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to]);

            $request = request();

            $all_shipments = ShipmentHelper::searchPayments($request, $query);

            $data['shipments'] = $all_shipments
                ->where('status_id', 3)
                // ->where('is_rider_has', 0)
                ->where('is_vendor_get_due', 0)
                ->where('deleted_at', Null)
                ->get();

            foreach ($data['shipments'] as $shipment) {
                if ($shipment->is_split_payment == 0) {
                    $data['sum'] =  $data['sum'] + $shipment->vendor_due;
                }
                else{
                    $to_vendor = 0;
                    $payment = Payment::where('shipment_id',$shipment->id)->where('is_split',1)->where('payment_method_id', 3)->where('is_vendor_get_due',0)->first();
                        $to_vendor = $payment->amount ?? 0;
                    $data['sum'] = $data['sum'] + ($shipment->vendor_due - $to_vendor);

                }
            }
        }
        return view('employee.transactions.pay_to_murchant', $data);
    }

    public function payToTheMerchant(Request $request)
    {
        $data['shipments'] = Shipment::whereIn('id', $request->payments)->get();

        $data['shipments']->each->update([
            'is_vendor_get_due' => 1,
            'updated_by' => Auth::guard('employee')->user()->name
        ]);

        foreach ($data['shipments'] as $shipment) {
            $data['payments'] = $shipment->payments->each->update([
                'is_vendor_get_due' => 1,
                'updated_by' => Auth::guard('employee')->user()->name
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
        return view('employee.transactions.withdrawal_bank', $data);
    }

    public function BankWithdrawal(Request $request)
    {
        $data['payments'] = Payment::whereIn('id', $request->payments)->get();

        $data['shipments'] = Shipment::whereIn('id', $data['payments']->pluck('shipment_id'))->get();

        $data['payments']->each->update([
            'is_bank_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('employee')->user()->name
        ]);

        $data['shipments']->each->update([
            'is_bank_has' => 0,
            'is_spl_get_due' => 1,
            'updated_by' => Auth::guard('employee')->user()->name
        ]);
        return response()->json(['code' => 200]);
    }
}