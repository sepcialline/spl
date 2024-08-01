<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecivedShipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function rider(){
        return $this->belongsTo(Rider::class,'rider_id','id');
    }
    public function vendor(){
        return $this->belongsTo(VendorCompany::class,'vendor_id','id');
    }

    protected $cats = ['date'];
}
