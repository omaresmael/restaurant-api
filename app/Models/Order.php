<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'waiter_id',
        'reservation_id',
        'total',
        'paid',
        'paid_at',
    ];

    protected $appends = [
        'customer',
        'table'
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'order_details')
            ->as('order_details')
            ->withPivot('amount_to_pay');
    }

    public function getCustomerAttribute()
    {
        return $this->reservation->customer;
    }

    public function getTableAttribute()
    {
        return $this->reservation->reservationTable;
    }
}
