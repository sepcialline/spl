<?php

namespace App\Http\Controllers\API\Search;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\ShipmentContent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SearchShipmentResource;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
        try {
            //code...
            $has_stock = null;
            $shipment_content = [];
            $shipment = Shipment::where('shipment_no', $request->shipment_no)->orWhere('shipment_refrence', $request->shipment_no)->orderBy('id','desc')->first();

            //return response(compact('shipment'), 200);
            $shipment_company = VendorCompany::where('id', $shipment->company_id)->first();
            $notes = $shipment->shipment_notes;

            if ($shipment_company->has_stock == 1) {
                $has_stock = 1;
                $shipment_content = ShipmentContent::where('shipment_id', $shipment->id)
                    ->with('product', function ($q) {
                        return $q->select('id', 'name')->get();
                    })->select('id', 'product_id', 'quantity')->get();
            } else {
                $has_stock = 0;
                $shipment_content = ShipmentContent::where('shipment_id', $shipment->id)->get();
            }
            $data =  new SearchShipmentResource($shipment);


            $message = ['success' => 0, 'message' => 'Success'];
            return response(compact('data', 'shipment_content',  'has_stock', 'message','notes'), 200);
        } catch (\Throwable $th) {
            //throw $th;
            $message = ['success' => 1, 'message' => $th];
            return response($th, 200);
        }
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
