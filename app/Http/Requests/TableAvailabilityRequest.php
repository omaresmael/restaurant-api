<?php

namespace App\Http\Requests;

use App\Rules\LessThanOrEqual;
use Illuminate\Foundation\Http\FormRequest;

class TableAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'to_time' => ['required', 'date_format:Y-m-d H:i:s', 'after:from_time'],
            'guests' => ['required', 'integer', new LessThanOrEqual($this->route('table')->capacity)],
        ];
    }
}
