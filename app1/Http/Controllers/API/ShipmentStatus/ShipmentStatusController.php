<?php

namespace App\Http\Controllers\API\ShipmentStatus;

use App\Models\Emirates;
use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\ShipmentStatuses;
use App\Http\Controllers\Controller;
use App\Models\Shipment;

class ShipmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ShipmentStatuses::where('id', '!=', '1')->where('id', '!=', '10')->where('id', '!=', '2')->select('id', 'name')->get();
        $payment_methods = PaymentMethods::select('id', 'name')->get();
        $payment_methods[] = ['id' => 0, 'name' => ['ar' => 'مقسم', 'en' => 'split']];
        $shipment = Shipment::where('shipment_no', Request()->shipment_no)->orwhere('shipment_refrence', Request()->shipment_no)->first();
        $note = $shipment->shipment_notes ?? '';
        $rider_should_recive = Null;
        if ($shipment) {
            $rider_should_recive = $shipment->rider_should_recive;
        }
        $message = ['success' => 0, 'message' => 'Success'];
        return response(compact('data', 'message', 'payment_methods', 'rider_should_recive','note'), 200);
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
        //
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
