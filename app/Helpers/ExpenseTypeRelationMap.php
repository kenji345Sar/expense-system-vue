<?php

namespace App\Helpers;

use InvalidArgumentException;

class ExpenseTypeRelationMap
{
    public static function getRelationName(string $type): string
    {
        return match ($type) {
            'transportation' => 'transportationExpenses',
            'supplies'       => 'suppliesExpenses',
            'business_trip'  => 'businessTripExpenses',
            'entertainment'  => 'entertainmentExpenses',
            default          => throw new InvalidArgumentException("Unknown type: $type"),
        };
    }
}
