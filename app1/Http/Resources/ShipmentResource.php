<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'shipment_no' => $this->shipment->shipment_no,
            'status' => $request['query'],
            'merchant_name' => $this->Company->getTranslations('name'),
            'customer_name' => $this->shipment->Client->getTranslations('name'),
            'customer_no' => $this->shipment->Client->mobile,
            'due_amount' => $this->shipment->rider_should_recive,
            'deliverd_date' => (string) $this->delivered_date,
            'status' => $this->Status->getTranslations('name'),
            'ref_code' => $this->shipment->shipment_refrence .' | '. $this->shipment->emirate->getTranslation('name','ar') . '-' . $this->shipment->city->getTranslation('name','ar')  .'-' .$this->shipment->delivered_address
        ];
    }
}
