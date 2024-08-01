<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class COA extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    public $translatable = ['name'];
    protected $guarded = [];

    public function coa_level_I(){
        return $this->hasMany(COALevelI::class,'coa_id','id');
    }

    public function TrialBalance(){
        return $this->belongsTo(TrialBalance::class,'trial_balance_id','id');
    }
}
