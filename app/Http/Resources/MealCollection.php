<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MealCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'message' => 'meals retrieved',
            'data' => $this->collection,
        ];
    }
}
