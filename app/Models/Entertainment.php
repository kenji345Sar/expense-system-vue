<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entertainment extends Model
{
    //

    protected $table = 'entertainment_expenses';

    protected $fillable = [
        'user_id',
        'expense_id',
        'entertainment_date',
        'client_name',
        'place',
        'amount',
        'content',
        'user_id',
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
