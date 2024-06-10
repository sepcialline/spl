<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrialBalance extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes, HasTranslations;
    public $translatable = ['name'];
    protected $guarded = [];
}
