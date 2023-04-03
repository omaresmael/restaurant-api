<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'capacity',
    ];

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class,'reservations')
            ->as('reservation')
            ->withPivot('from_time', 'to_time');
    }

    public function isReserved(string $from, string $to): bool
    {
        //TODO: use joins if you got time
        return $this->customers()->wherePivot('from_time', '<=',$to)
            ->where('to_time', '>=', $from)
            ->exists();
    }

}
