<?php

namespace App\Http\Controllers\Vendor;

use Carbon\Carbon;
use App\Models\Rider;
use App\Models\Cities;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\PaymentMethods;
use App\Helpers\ShipmentHelper;
use App\Models\ShipmentStatuses;
use App\Http\Controllers\Controller;
use App\Models\Payment;

class ReportController extends Controller
{


    public function paymentsReport()
    {
        $data['companies'] = VendorCompany::select('id', 'name')->get();
        $data['riders'] = Rider::select('id', 'name')->get();
        $data['payment_methods'] = PaymentMethods::select('id', 'name')->get();
        $data['shipment_status'] = ShipmentStatuses::select('id', 'name')->get();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name')->get();
        $data['branches'] = Branches::select('id', 'branch_name')->get();
        $date_from = Carbon::today()->format('y-m-d');
        $date_to = Carbon::today()->format('y-m-d');

        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }

        $query = Payment::query()->whereBetween('date', [$date_from, $date_to]);

        $request = request();

        $all_payments = ShipmentHelper::searchPayments($request, $query);

        $data['from'] = $date_from;
        $data['to'] = $date_to;
        $data['vendor_amount_due'] = 0;

        $data['payments'] = $all_payments->join('shipments', 'payments.shipment_id', '=', 'shipments.id')
            ->orderBy('payments.shipment_id', 'ASC')
            ->orderBy('payments.date', 'ASC')
            ->orderBy('payments.payment_method_id', 'ASC')
            ->select('payments.*') //see PS:
            ->paginate(50);


        $data['cash_on_delivery'] = Payment::whereIn('id', $data['payments']->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
        $data['transfer_to_Bank'] = Payment::whereIn('id', $data['payments']->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');

        $data['transfer_to_vendor_company'] = Payment::whereIn('id', $data['payments']->pluck('id'))->where('payment_method_id', 3)->sum('amount');

        $data['total'] = Payment::whereIn('id', $data['payments']->pluck('id'))->where('deleted_at', Null)->sum('amount');



        // calc vandor due
        $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to]);

        $request = request();

        $all_shipments = ShipmentHelper::searchShipment($request, $query);

        $data['shipments_vendor_due'] = $all_shipments
            ->where('status_id', 3)
            // ->where('is_rider_has', 0)
            ->where('is_vendor_get_due', 0)
            ->where('deleted_at', Null)
            ->get();

        foreach ($data['shipments_vendor_due'] as $shipment) {
            if ($shipment->is_split_payment == 0) {
                $data['vendor_amount_due'] =  $data['vendor_amount_due'] + $shipment->vendor_due;
            } else {
                $to_vendor = 0;
                $payment = Payment::where('shipment_id', $shipment->id)->where('is_split', 1)->where('payment_method_id', 3)->where('is_vendor_get_due', 0)->first();
                $to_vendor = $payment->amount ?? 0;
                $data['vendor_amount_due'] = $data['vendor_amount_due'] + ($shipment->vendor_due - $to_vendor);
            }
        }



        if (request()->input('action') == 'report') {

            return view('vendor.shipment.reports.payment_report', $data);
        } else {

            return view('vendor.shipment.reports.payments', $data);
        }
    }
}
