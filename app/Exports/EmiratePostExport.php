<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Payment;
use App\Models\Vendors;
use App\Models\Despatch;
use App\Models\Emirates;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmiratePostExport implements FromCollection, WithHeadings
{
    private $request;

    public function __construct()
    {
        $this->request = request();
    }

    public function collection()
    {

        // return $payments = DB::table('payments')->whereBetween('payments.date', [$this->request->date_from, $this->request->date_to])
        //     ->join('shipments', 'shipments.id', '=', 'payments.shipment_id')
        //     ->join('users', 'shipments.user_id', '=', 'users.id')
        //     ->join('emirates', 'emirates.id', '=', 'shipments.delivered_emirate_id')
        //     ->join('vendor_companies', 'vendor_companies.id', '=', 'payments.company_id')
        //     ->select(
        //         'users.name',
        //         'shipments.shipment_no',
        //         'payments.date',
        //         'payments.origin_country',
        //         'payments.origin_city',
        //         'payments.destination_country',
        //         'payments.shipment_type',
        //         'payments.shipment_status',
        //         'payments.weight',
        //         'shipments.specialline_due',
        //         'vendor_companies.name',
        //         'shipments.shipment_refrence',
        //         'payments.additional_info_2'
        //     )->get();

        $shipemnts = Shipment::whereBetween('delivered_date', [$this->request->date_from, $this->request->date_to])->whereIn('status_id',[3,9])->pluck('id');

        $data = array();
        foreach ($shipemnts as $shipment_id) {
            $shipment = Shipment::where('id', $shipment_id)->first();
            $data[] = [
                $shipment->Client->getTranslation('name', 'en'),
                $shipment->shipment_no,
                $shipment->delivered_date,
                'United Arab Emirates',
                'Ajman',
                'United Arab Emirates',
                $shipment->emirate->getTranslation('name', 'en'),
                'document',
                'Delivered',
                '0',
                ($shipment->fees_type_id == 2) ? $shipment->Company->vendor_rate : $shipment->Company->customer_rate,
                $shipment->Company->getTranslation('name', 'en'),
                $shipment->shipment_refrence,
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'CustomerName',
            'AWBNo',
            'TransactionDate',
            'OriginCountry',
            'OriginCity',
            'DestinationCountry',
            'DestinationCity',
            'ShipmentType',
            'ShipmentStatus',
            'Weight',
            'deliveryCharge',
            'Dispatcher',
            'AdditionalInfo1',
            'AdditionalInfo2'
        ];
    }
}
