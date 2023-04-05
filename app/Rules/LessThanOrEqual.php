<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LessThanOrEqual implements ValidationRule
{
    public function __construct(private int $referenceValue)
    {

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($value > $this->referenceValue) {
            if ($attribute === 'guests') {
                $fail('the guests exceeds the capacity of the table');
            }
            $fail($attribute.' must be greater less or equal to '.$this->referenceValue);
        }
    }
}
