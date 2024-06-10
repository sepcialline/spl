<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'rider_id',
        'expense_type',
        'car_plate',
        'value',
        'payment_type',
        'notes',
        'photo'
    ];

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }

    public function expense()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type');
    }

    public function plate()
    {
        return $this->belongsTo(CarPLate::class, 'car_plate');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }
}
