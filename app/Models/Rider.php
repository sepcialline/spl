<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasTranslations, SoftDeletes;

    protected $guard = 'rider';
    public $translatable = ['name'];
    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleTypes::class, 'vehicle_type', 'id');
    }

    public function emirate()
    {
        return $this->belongsTo(Emirates::class);
    }
    public function city()
    {
        return $this->belongsTo(Cities::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
}
