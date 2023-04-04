<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function getCustomerAttribute()
    {
        return $this->reservation->customer;
    }

    public function getTableAttribute()
    {
        return $this->reservation->reservationTable;
    }
}
