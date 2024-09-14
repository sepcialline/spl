<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountingEntries extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['debit_account_name', 'credit_account_name'];

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(JounalType::class, 'journal_type_id');
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }


    public function costCenter(){
        return $this->belongsTo(CarPLate::class, 'cost_center','id');
    }
    public function branch(){
        return $this->belongsTo(Branches::class, 'branch_id','id');
    }
    public function compoundWith()
    {
        return $this->hasMany(AccountingEntries::class, 'compound_entry_with', 'id');
    }
    
}
