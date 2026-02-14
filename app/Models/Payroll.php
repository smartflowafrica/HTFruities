<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'basic_salary', 'status', 'month',
        'bonus', 'deduct', 'total_allownce', 'total_deduction', 'total_salary',
    ];

    protected $casts = [
        'bonus' => 'array',
        'deduct' => 'array'
    ];

    function user(){
        return $this->belongsTo(User::class);
    }
}
