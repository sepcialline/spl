<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'branch_id',
        'warehouse_id',
        'quantity'
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function branch(){
        return $this->belongsTo(Branches::class);
    }
}
