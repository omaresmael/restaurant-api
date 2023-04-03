<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableAvailabilityRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'from_time' => ['required','date_format:Y-m-d H:i:s'],
            'to_time' => ['required','date_format:Y-m-d H:i:s'],
            'guests' => ['required','integer',Rule::exists('tables', 'id')->where(function ($query) {
                $query->where('capacity', '>=', $this->input('guests'));

            }),],
        ];
    }

    public function messages(): array
    {
        return [
            'guests.exists' => 'the guests exceeds the capacity of the table',
        ];
    }
}
