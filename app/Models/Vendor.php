<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasTranslations,SoftDeletes,HasRoles;

    protected $guard = 'vendor';
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

    public function company(){
        return $this->belongsTo(VendorCompany::class,'company_id');
    }

    public function companies(){
        return $this->hasMany(VendorCompany::class,'vendor_id','id');
    }
}
