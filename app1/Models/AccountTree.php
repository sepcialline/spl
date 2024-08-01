<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountTree extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['account_name'];
    protected $guarded = [];


    public function accounts(): HasMany
    {
        return $this->hasMany(AccountTree::class, 'account_parent');
    }

    public function childrenAccounts()
    {
        return $this->hasMany(AccountTree::class, 'account_parent')->with('accounts');
    }
}
