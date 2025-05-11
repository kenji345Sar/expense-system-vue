<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessTrip extends Model
{
    //
    protected $table = 'business_trip_expenses';

    protected $fillable = [
        'user_id',
        'expense_id',
        'business_trip_date',
        'departure',
        'destination',
        'transportation',
        'purpose',
        'amount',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
