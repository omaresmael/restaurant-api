<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'available_quantity' => $this->available_quantity,
            'price' => $this->price,
            'discount' => $this->discount,
        ];
    }
}
