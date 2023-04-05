<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
            'meals' => ['required', 'array'],
            'meals.*.meal_id' => ['required', 'integer', 'exists:meals,id'],
            'meals.*.amount_to_pay' => ['required', 'numeric', 'min:0'],
            'waiter_id' => ['required', 'integer'],
        ];
    }
}
