<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    protected function discountedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->price - ($this->price * ($this->discount / 100))),
        );
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_details')
            ->as('order_details')
            ->withPivot('amount_to_pay');
    }
}
