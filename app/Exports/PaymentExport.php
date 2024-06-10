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
        $request =Request();
        $date_from= '';
        $date_to = '';
        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('Y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('Y-m-d');
        }

        $query = Payment::query();


        $all_payments = ShipmentHelper::searchPayments($request, $query);


        $data['from'] = $date_from;
        $data['to'] = $date_to;




        return view('exports.reports.payments', [
            'payments' =>$all_payments->whereBetween('date', [$date_from, $date_to])->get()
        ]);
    }
}
