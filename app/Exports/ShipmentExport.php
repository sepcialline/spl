<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Shipment;
use App\Helpers\ShipmentHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ShipmentExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        if (request()->date_from) {
            $date_from = Carbon::parse(request()->date_from)->format('y-m-d');
        } else {
            $date_from = Carbon::now()->format('Y-m-d');
        }
        if (request()->date_to) {
            $date_to = Carbon::parse(request()->date_to)->format('y-m-d');
        }else{
            $date_to =  Carbon::now()->format('Y-m-d');
        }

        $query = Shipment::query()->whereBetween('delivered_date', [$date_from, $date_to])->with('Client');

        $request = request();

        $all_shipments = ShipmentHelper::searchShipment($request, $query);

        return view('exports.reports.shipments', [
            'shipments' => $all_shipments->get()
        ]);
    }
}
