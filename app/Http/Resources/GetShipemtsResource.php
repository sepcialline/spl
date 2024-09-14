<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetShipemtsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shipment_reference' => $this->shipment_refrence,
            'customer_id' => $this->user_id,
            'customer_phone' => $this->customer_phone,
            'customer_phone' => $this->Client->mobile,
            'amount' => $this->shipment_amount,
            'status_id' => $this->status_id,
            'status_name_ar' => $this->Status->getTranslation('name', 'ar'),
            'status_name_en' => $this->Status->getTranslation('name', 'en'),
        ];
    }
}
