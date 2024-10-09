<?php declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Position implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validPositions = [
            'F', 'FW' , 'Forward',
            'M', 'MID', 'Midfielder',
            'D', 'DEF', 'Defender',
            'G', 'GK' , 'Goalkeeper'
        ];

        if (!in_array($value, $validPositions)) {
            $fail("The selected :attribute is invalid.");
        }
    }
}