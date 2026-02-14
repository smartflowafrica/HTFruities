<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variation_id',
        'qty',
        'location_id',
        'user_id',
        'guest_user_id',
        'price', // Custom price for parfait
        'data',  // Custom data (ingredients list)
    ];

    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
