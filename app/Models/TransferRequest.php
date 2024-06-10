<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'from_branch',
        'requested_by',
        'quantity'
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function fromBranch(){
        return $this->belongsTo(Branches::class,'from_branch');
    }
}
