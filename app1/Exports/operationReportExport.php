<?php

namespace App\Exports;

use App\Models\Shipment;
use App\Models\Tracking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class operationReportExport implements FromView
{

    public function view(): View
    {
        return view('exports.reports.operation', [
            'shipment' => Shipment::first() ,
        ]);
    }
}
