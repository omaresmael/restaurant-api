<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $with = [
        'meals',
        'reservation',
    ];

    protected $fillable = [
        'waiter_id',
        'reservation_id',
        'total',
        'paid',
        'paid_at',
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

    protected function customer(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservation->customer,
        );
    }
    protected function table(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservation->reservationTable,
        );
    }

    private function calculateTotalPrice(): float
    {
        return $this->meals->sum(fn ($meal) => $meal->price);
    }

    private function calculatePaidPrice(): float
    {
        return $this->meals->sum(fn ($meal) => $meal->order_details->amount_to_pay);
    }

    public function calculateTotalAndPaidPrices(): array
    {
        $total = $this->calculateTotalPrice();
        $paid = $this->calculatePaidPrice();

        return [$total, $paid];
    }


}
