<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory , HasTranslations;
    public $translatable = ['name'];
    protected $guarded = [];

    public function vendorCompany(){
        return $this->belongsTo(VendorCompany::class,'company_id');
    }

    public function branch(){
        return $this->belongsTo(Branches::class,'branch_id');
    }
}
