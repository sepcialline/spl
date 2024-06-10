<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseTransfer extends Model
{
    use HasFactory;
    protected $fillable=[
        'branch_id',
        'product_id',
        'company_id',
        'quantity'
    ];
    public function branch(){
        return $this->belongsTo(Branches::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function vendorCompany(){
        return $this->belongsTo(VendorCompany::class,'company_id');
    }
}
