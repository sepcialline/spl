<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ExpenseType extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];
}
