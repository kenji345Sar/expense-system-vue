<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    //
    protected $table = 'supplies_expenses';

    protected $fillable = [
        'supply_date',
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
