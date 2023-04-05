<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'customer_id',
        'from_time',
        'to_time',
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function reservationTable(): BelongsTo
    {
        return $this->belongsTo(Table::class, foreignKey: 'table_id', relation: 'tables');
    }
}
