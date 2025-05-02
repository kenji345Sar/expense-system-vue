<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntertainmentExpense extends Model
{
    //
    protected $fillable = [
        'user_id',
        'entertainment_date',
        'client_name',
        'place',
        'amount',
        'content',
        'user_id',
    ];
}
