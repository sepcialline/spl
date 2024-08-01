<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branches extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    public $translatable = ['branch_name','branch_address'];
    protected $guarded = [];

    public function emirate(){
        return $this->belongsTo(Emirates::class,'branch_emirat_id');
    }

}
