<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationExpense extends Model
{
    //
    protected $fillable = [
        'use_date',
        'departure',
        'arrival',
        'route',
        'amount',
        'remarks',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
