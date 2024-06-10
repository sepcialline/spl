<?php

namespace App\Http\Controllers\API\Shipment;

use App\Helpers\ShipmentHelper;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethods;
use App\Models\Shipment;
use App\Models\ShipmentStatuses;
use App\Models\User;
use App\Models\VendorCompany;
use Illuminate\Http\Request;

class ShipmentOperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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


        $guard = 'rider';
        $shipment = Shipment::where('shipment_no', $request->shipmentNo)->first();

        ShipmentHelper::shipmentChangeStatus($request, $shipment, $guard);

        $status = ShipmentStatuses::where('id', $request->status_id)->first();
        // return $status;
        $client = User::where('id', $shipment->user_id)->first();
        $company = VendorCompany::where('id', $shipment->company_id)->first();
        $payment_methods = PaymentMethods::select('id','name')->get();
        $message = ['success' => 0, 'message' => 'Success',];
        return response(compact('message', 'status', 'company', 'client', 'shipment','payment_methods'), 200);
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
