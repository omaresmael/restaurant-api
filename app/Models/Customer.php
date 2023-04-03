<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
    ];

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Table::class,'reservations')
            ->as('reservation')
            ->withPivot('from_time', 'to_time');
    }

    public function waitingList(): HasOne
    {
        return $this->hasOne(WaitingList::class,'waiting_lists');
    }

}
