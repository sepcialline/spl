<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirebasePushNotification extends Model
{
    use HasFactory;
    public $translatable = ['pending','confirm','delivere','delay','transfer','cancel','damage'];
}
