<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TableResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nearest available' => $this->customers->first()->reservation->from_time,
        ];
    }
}
