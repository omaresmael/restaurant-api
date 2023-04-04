<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeed extends Seeder
{
    public function run(): void
    {
        Reservation::factory()->count(10)->create();
    }
}
