<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetCompaniesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=> $this->id,
            'name_ar'=> $this->getTranslation('name','ar') ?? Null,
            'name_en'=> $this->getTranslation('name','en') ?? Null,
            'logo'=> $this->logo ? asset("build/assets/img/uploads/logos/".$this->logo) : asset("build/assets/img/uploads/avatars/1.png/"),
            'vendor_id'=> $this->vendor_id ?? Null,
            'notifications_count' => 0
        ];
    }
}
