<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorCompany extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;
    public $translatable = ['name', 'address'];
    protected $guarded = [];

    public function emirate()
    {
        return $this->belongsTo(Emirates::class);
    }
    public function city()
    {
        return $this->belongsTo(Cities::class);
    }


    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'company_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }
}
