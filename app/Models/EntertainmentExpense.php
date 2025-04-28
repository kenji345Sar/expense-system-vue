<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntertainmentExpense extends Model
{
    //
    protected $fillable = [
        'date',
        'client_name',
        'place',
        'amount',
        'content',
    ];
}
