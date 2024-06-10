<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'from_branch',
        'to_branch',
        'done_by',
        'quantity'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function fromBranch(){
        return $this->belongsTo(Branches::class,'from_branch');
    }
    public function toBranch(){
        return $this->belongsTo(Branches::class,'to_branch');
    }
}
