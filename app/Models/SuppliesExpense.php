<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppliesExpense extends Model
{
    //
    protected $fillable = [
        'date',
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
        'remarks',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
