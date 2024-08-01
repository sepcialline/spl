<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'branch_id',
        'company_id',
        'quantity',
        'operation_id',
        'added_by',
        'date',
        'notes',
        'dispatch_ref_no'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branches::class);
    }

    public function operation()
    {
        return $this->belongsTo(WarehouseOperations::class, 'operation_id');
    }
    public function company()
    {
        return $this->belongsTo(VendorCompany::class, 'company_id');
    }
    public function user()
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }
}
