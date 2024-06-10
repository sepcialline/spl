<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SearchShipmentResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'details' => [
                'shipment_no' => $this->shipment_no,
                'shipment_amount' => $this->shipment_amount,
                'rider_should_recive' => $this->rider_should_recive,
                'delivery_fees' => $this->delivery_fees + $this->delivery_extra_fees,
                'shipment_notes' => $this->shipment_notes,
                'canTake' => ($this->rider_id == NULL)  ? true : false,
                'canFinish' => ($this->rider_id == Auth::id())  ? true : false,
            ],
            'merchant' => [
                'name' => $this->Company->getTranslations('name'),
                'image' => asset('build/assets/img/uploads/vendors/' . $this->Company->logo ?? Null),
            ],
            'customer' => [
                'name' => $this->Client->getTranslations('name'),
                'mobileNo' => $this->Client->mobile,
                'image' => asset('build/assets/img/uploads/avatars/' . $this->Client->photo ?? Null),
            ],
            'status' => $this->Status->getTranslations('name'),
            'status_id' => $this->status_id
        ];
    }
}
