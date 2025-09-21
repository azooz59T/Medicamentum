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
        'price',
        'stock'
    ];

    // converts an attribute's value to a more usable data type from the database
    protected $casts = [
        'price' => 'decimal:2'
    ];

    // Define what dates should be treated as Carbon instances
    protected $dates = ['deleted_at'];

        /**
     * Check if product is in stock
     */
    public function isInStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    /**
     * Check if product is out of stock
     */
    public function isOutOfStock()
    {
        return $this->stock <= 0;
    }

    /**
     * Reduce stock when product is purchased
     */
    public function reduceStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }
}
