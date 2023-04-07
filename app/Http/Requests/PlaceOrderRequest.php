<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'meals.*.meal_id' => ['required', 'integer', Rule::exists('meals', 'id')->where(function (Builder $query) {
                return $query->where('available_quantity', '>', 0);
            })],
            'meals.*.amount_to_pay' => ['required', 'numeric', 'min:0'],
            'waiter_id' => ['required', 'integer'],
        ];
    }
}
