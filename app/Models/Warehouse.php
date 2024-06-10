<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Warehouse extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['warehouse_name'];
    protected $guarded = [];

    public function branch(){
        return $this->belongsTo(Branches::class);
    }
}
