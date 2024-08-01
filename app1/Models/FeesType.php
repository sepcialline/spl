<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeesType extends Model
{
    use HasFactory ,HasTranslations , SoftDeletes;

    public $translatable = ['name'];
}
