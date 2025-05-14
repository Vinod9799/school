<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
     protected $fillable = [
        'driver_id',
        'basic',
        'fuel_expense',
        'other_expense',
        'total_pay',
    ];
}
