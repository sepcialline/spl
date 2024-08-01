<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    public $translatable = ['name','address', 'description'];
    protected $guarded = [];
}
