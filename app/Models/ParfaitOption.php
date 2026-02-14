<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParfaitOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type', // base, fruit, topping, drizzle
        'price',
        'image',
        'description',
        'is_active',
        'sort_order',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
