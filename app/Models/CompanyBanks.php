<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBanks extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
