<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopifyConfig extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'app_id',
    //     'access_token',
    // ];

    protected $guarded = [];
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
