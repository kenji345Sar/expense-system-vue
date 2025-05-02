<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessTripExpense extends Model
{
    //
    protected $fillable = [
        'business_trip_date',
        'departure',
        'destination',
        'transportation',
        'purpose', // ← これ
        'amount',
        'remarks',
    ];
}
