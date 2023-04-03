<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeAvailable(Builder $query, string $from,string $to, int $guests): void
    {
        $query->where('capacity', '>=', $guests)
            ->whereDoesntHave('customers', function (Builder $query) use ($from, $to) {
                $query->where('from_time', '<=', $to)
                    ->where('to_time', '>=', $from);
            });
    }

    public function scopeNearestAvailable(Builder $query, int $guests): void
    {
        $query->where('capacity', '>=', $guests)
            ->with('customers')
            ->whereRelation('customers', function (Builder $query) {
                $query->orderBy('to_time');
            });
    }

}
