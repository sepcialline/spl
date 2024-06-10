<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tracking extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =[];

    public function shipment(){
        return $this->belongsTo(Shipment::class,'shipment_id');
    }

    public function status(){
        return $this->belongsTo(ShipmentStatuses::class,'status_id');
    }

    public function Company(){
        return $this->belongsTo(VendorCompany::class,'company_id');
    }
    public function Rider(){
        return $this->belongsTo(Rider::class,'rider_id');
    }

}
