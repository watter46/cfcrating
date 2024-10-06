<?php declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AdminKey implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 大文字が含まれているかを確認
        if (!preg_match('/[A-Z]/', $value)) {
            $fail('The :attribute must contain at least one uppercase letter.');
        }

        // ハイフンが含まれているかを確認
        if (!str_contains($value, '-')) {
            $fail('The :attribute must contain at least one hyphen.');
        }

        // 数字が含まれているかを確認
        if (!preg_match('/\d/', $value)) {
            $fail('The :attribute must contain at least one number.');
        }
    }
}