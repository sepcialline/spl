<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = [];

    public function shipmentContents(){
        return $this->hasMany(ShipmentContent::class,'shipment_id');
    }

    public function Company(){
        return $this->belongsTo(VendorCompany::class , 'company_id');
    }

    public function Client(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function Status(){
        return $this->belongsTo(ShipmentStatuses::class,'status_id');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethods::class,'payment_method_id');
    }

    public function feesType(){
        return $this->belongsTo(FeesType::class,'fees_type_id');
    }

    public function Rider(){
        return $this->belongsTo(Rider::class,'rider_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class,'shipment_id');
    }

    public function emirate(){
        return $this->belongsTo(Emirates::class,'delivered_emirate_id');
    }
    public function city(){
        return $this->belongsTo(Cities::class,'delivered_city_id');
    }

    public function lastTracking(){
        return $this->hasOne(Tracking::class)->latest();
    }

    protected $dates = ['delivered_date','created_date'];

}
