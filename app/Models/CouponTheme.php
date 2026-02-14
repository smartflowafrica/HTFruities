<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponTheme extends Model
{
    use HasFactory;
    
    protected $fillable = ['coupon_id', 'theme_id'];
}
