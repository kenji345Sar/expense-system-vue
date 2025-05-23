<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    //

    protected $table = 'transportation_expenses';

    protected $fillable = [
        'user_id',
        'expense_id',
        'use_date',
        'departure',
        'arrival',
        'route',
        'amount',
        'remarks',
        'display_order',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
