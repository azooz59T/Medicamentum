<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory, SoftDeletes;

    // make the following attributes mass assigned when the product is being created on by admin
    protected $fillable = [
        'name',
        'category',
        'description',
        'image',
        'price'
    ];

    // converts an attribute's value to a more usable data type from the database
    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Define what dates should be treated as Carbon instances
    protected $dates = ['deleted_at'];
}
