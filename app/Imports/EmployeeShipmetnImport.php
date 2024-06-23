<?php

namespace App\Imports;

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Cities;
use App\Models\Shipment;
use App\Models\Tracking;
use App\Models\VendorCompany;
use App\Helpers\ShipmentHelper;
use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeeShipmetnImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    public function __construct()
    {
    }

    public function model(array $row)
    {

        if (!array_filter($row)) {
            return null;
        }

        $request = null;
        $client_emirate_id = Null;
        $fees_type_id = Null;
        $payment_type_id = Null;

        //Emirate
        if ($row['client_emirate'] === "Ajman") {
            $client_emirate_id = 1;
        }
        if ($row['client_emirate'] === "Sharjah") {
            $client_emirate_id = 2;
        }
        if ($row['client_emirate'] === "Dubai") {
            $client_emirate_id = 3;
        }
        if ($row['client_emirate'] === "Abu Dhabi") {
            $client_emirate_id = 4;
        }
        if ($row['client_emirate'] === "Al Ain") {
            $client_emirate_id = 5;
        }
        if ($row['client_emirate'] === "Fujairah") {
            $client_emirate_id = 6;
        }
        if ($row['client_emirate'] === "Ras Al-Khaimah") {
            $client_emirate_id = 7;
        }
        if ($row['client_emirate'] === "Umm Al Quwain") {
            $client_emirate_id = 8;
        }


        // fees Type
        if ($row['fees_type'] === "On Client") {
            $fees_type_id = 1;
        }
        if ($row['fees_type'] === "On Vendor") {
            $fees_type_id = 2;
        }
        if ($row['fees_type'] == "Free") {
            $fees_type_id = 3;
        }

        //payment method
        if ($row['payment_method'] == "COD") {
            $payment_type_id = 1;
        }
        if ($row['payment_method'] == "SP-TR") {
            $payment_type_id = 2;
        }
        if ($row['payment_method'] == "Transfer to vendor") {
            $payment_type_id = 3;
        }


        $guard = 'employee';
        $city = Cities::where('emirate_id', $client_emirate_id)->first();
        $request = [
            'shipment_refrence' =>  rand(100000, 999999),
            'client_name' => $row['client_name'] . ' ' . $row['shipment_refrence'],
            'client_phone' => $row['client_phone'],
            'client_email' => $row['client_email'],
            'client_emirate_id' => $client_emirate_id,
            'client_city_id' => $city->id,
            'client_address' => $row['client_address'],
            'payment_method_id' => $payment_type_id,
            'fees_type_id' => $fees_type_id,
            'shipment_amount' => $row['shipment_amount'],
            'delivery_fees' => VendorCompany::where('id', Request()->company_id)->first()->vendor_rate,
            'delivery_extra_fees' => 0,
            'delivered_date' => Request()->delivered_Date,
            'company_id' => Request()->company_id,
            'branch_created_id' => Request()->branch_created,
            'branch_destination_id' => Request()->branch_created,
            'shipment_notes' => $row['notes'],
            'is_external_order' => 0,
        ];
        $user = ShipmentHelper::checkUser($request, $guard);


        $states = ShipmentHelper::states($request);

        $shipment = ShipmentHelper::storeShipment($request, $user, $guard, $states['rider_should_recive'], $states['vendor_due'], $states['specialline_due'], $ref = '');

        // $action = 'create shipment from excel | إنشاء شحنة من ملف إكسل';

        // ShipmentHelper::shipmentTracking($shipment , $guard, $action, $rider = Null );
    }

    public function rules(): array
    {
        return [
            'client_phone' => 'required',
            'client_name' => 'required',
            'client_emirate' => 'required',
            'client_address' => 'required',
            'payment_method' => 'required',
            'fees_type' => 'required',
            'shipment_amount' => 'required',
        ];
    }


    public function customValidationMessages()
    {
        return [
            'client_phone.required' => 'رقم الهاتف مطلوب :attribute.',
            'client_name.required' => 'اسم الزبون مطلوب :attribute.',
            'client_emirate.required' => 'الامارة مطلوبة :attribute.',
            'client_address.required' => 'العنوان مطلوب :attribute.',
            'payment_method.required' => 'طرقة الدفع مطلوبة :attribute.',
            'fees_type.required' => 'الرسوم على من مطلوبة :attribute.',
            'shipment_amount.required' => 'مبلغ الشحنة مطلوبة :attribute.',
        ];
    }
}
