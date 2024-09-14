<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function company(){
        return $this->belongsTo(VendorCompany::class,'company_id');
    }
    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }
}
