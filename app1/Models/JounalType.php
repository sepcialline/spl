<?php

namespace App\Models;

use FontLib\Table\Type\name;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JounalType extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];

}
