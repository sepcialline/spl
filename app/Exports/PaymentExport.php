<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\VendorCompany;
use App\Helpers\ShipmentHelper;
use Flasher\Laravel\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Psy\CodeCleaner\AssignThisVariablePass;

class PaymentExport implements FromView
{

    public function view(): View
    {
        $request = Request();
        $date_from = '';
        $date_to = '';
        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('Y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('Y-m-d');
        }

        $query = Payment::query()->whereBetween('date', [$date_from, $date_to]);


        $all_payments = ShipmentHelper::searchPayments($request, $query);


        $data['from'] = $date_from;
        $data['to'] = $date_to;


        // $data['cash_on_delivery'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
        $data['cash_on_delivery'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->sum('amount');
        // $data['cod_sp_income'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->where('amount', '>', 0)->sum('delivery_fees');
        $data['cod_sp_income'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 1)->where('amount', '>', 0)->sum('delivery_fees');
        $data['cod_vendor_balance'] = $data['cash_on_delivery'] - $data['cod_sp_income'];


        // $data['transfer_to_Bank'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');
        $data['transfer_to_Bank'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->sum('amount');
        // $data['tr_bank_sp_income'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->where('amount', '>', 0)->sum('delivery_fees');
        $data['tr_bank_sp_income'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', 2)->where('amount', '>', 0)->sum('delivery_fees');
        $data['tr_bank_vendor_balance'] = $data['transfer_to_Bank'] - $data['tr_bank_sp_income'];

        // $data['transfer_to_vendor_company'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('due_amount', '<', 0)->sum('due_amount');
        $data['transfer_to_vendor_company'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('due_amount', '<', 0)->sum('due_amount');


        // $data['total'] = Payment::where('is_spl_get_due',0)->where('is_vendor_get_due',0)->whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->sum('amount');
        $data['total'] = Payment::whereIn('id', $all_payments->pluck('id'))->where('deleted_at', Null)->where('payment_method_id', '!=', 3)->sum('amount');
        $data['net_income'] =  $data['cod_sp_income'] +  $data['tr_bank_sp_income'] + (- ($data['transfer_to_vendor_company']));
        $data['vendor_account'] =  ($data['cod_vendor_balance']) +  ($data['tr_bank_vendor_balance']) - (- ($data['transfer_to_vendor_company']));






        return view('exports.reports.payments', [
            'payments' => $all_payments->whereBetween('date', [$date_from, $date_to])->get(),
            'cash_on_delivery'=>$data['cash_on_delivery'],
            'cod_sp_income'=>$data['cod_sp_income'],
            'cod_vendor_balance'=>$data['cod_vendor_balance'],
            'transfer_to_Bank'=>$data['transfer_to_Bank'],
            'tr_bank_sp_income'=>$data['tr_bank_sp_income'],
            'tr_bank_vendor_balance'=>$data['tr_bank_vendor_balance'],
            'transfer_to_vendor_company'=>$data['transfer_to_vendor_company'],
            'total'=>$data['total'],
            'net_income'=>$data['net_income'],
            'vendor_account'=>$data['vendor_account'],
        ]);
    }
}
