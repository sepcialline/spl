<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory , SoftDeletes;
    protected $guarded = [];

    public function branch(){
        return $this->belongsTo(Branches::class,'branch_created');
    }
    public function shipment(){
        return $this->belongsTo(Shipment::class,'shipment_id');
    }
    public function paymentMethod(){
        return $this->belongsTo(PaymentMethods::class,'payment_method_id');
    }
    public function company(){
        return $this->belongsTo(VendorCompany::class,'company_id');
    }
    public function Rider(){
        return $this->belongsTo(Rider::class,'rider_id');
    }

}
