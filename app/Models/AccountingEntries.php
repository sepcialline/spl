<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingEntries extends Model
{
    use HasFactory;

    public function type(){
        return $this->belongsTo(AccountingEntries::class,'journal_type_id');
    }
}
