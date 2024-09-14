<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetShipmentDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'shipment_details'=>[
            'shipment_id'=>$this['shipment']->id,
            'shipment_refrence' => $this['shipment']->shipment_refrence,
            'added_date'=>Carbon::parse($this['shipment']->created_date)->format('Y-m-d'),
            'delivered_date'=>Carbon::parse($this['shipment']->delivered_date)->format('Y-m-d'),

            'company_name_ar'=>$this['shipment']->company->getTranslation('name','ar') ?? Null,
            'company_name_en'=>$this['shipment']->company->getTranslation('name','en') ?? Null,

            'shipment_amount'=>$this['shipment']->shipment_amount ?? Null,
            'delivery_fees'=>$this['shipment']->delivery_fees ?? Null,
            'delivery_extra_fees'=>$this['shipment']->delivery_extra_fees ?? Null,
            'payment_method'=>$this['shipment']->paymentMethod->name ?? Null,
            'fees_type_id'=>$this['shipment']->feesType->name ?? Null,
            'shipment_notes'=>$this['shipment']->shipment_notes ?? Null,

            'has_stock' => $this['has_stock'],
            'shipment_content'=>$this['shipment_content']
            ],



            'customer_details'=>[
                'customer_name'=>$this['shipment']->Client?->name ?? Null,
                'customer_phone'=>$this['shipment']->Client?->mobile ?? Null,
                'customer_address'=>$this['shipment']->delivered_address ?? Null,
                'customer_city'=>$this['shipment']->city->name ?? Null,
                'customer_emirate'=>$this['shipment']->emirate->name ?? Null,
            ],


        ];
    }
}
