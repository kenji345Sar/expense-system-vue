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
    ];
}
