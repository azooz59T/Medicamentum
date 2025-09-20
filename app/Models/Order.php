<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // make the following attributes mass assigned when the oder is being created on the checkout page
    protected $fillable = [
        'name',
        'phone',
        'address',
        'cart_items',
        'total_amount',
        'status'
    ];

    // converts an attribute's value to a more usable data type from the database
    protected $casts = [
        'cart_items' => 'array',
        'total_amount' => 'decimal:2'
    ];
}
