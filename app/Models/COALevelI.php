<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class COALevelI extends Model
{
    use HasFactory;
    use HasFactory,SoftDeletes,HasTranslations;
    public $translatable = ['name'];
    protected $guarded = [];

    public function coa_level_II(){
        return $this->hasMany(COALevelII::class,'coa_i_id','id');
    }
}
