<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    const PAGINATION_COUNT = 10;
    protected $fillable = [
        'name',
        'description',
        'available_quantity',
        'initial_quantity',
        'price',
        'discount',
    ];
}
