<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Bank extends Model
{
    use HasFactory , HasTranslations;

    protected $fillable = ['name_bank', 'logo','short_cut'];
    public $translatable = ['name_bank'];
}
