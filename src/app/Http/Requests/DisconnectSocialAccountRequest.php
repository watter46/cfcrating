<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DisconnectSocialAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function validateDisconnect()
    {
        // メールアドレスが登録されていない場合はエラーを返す
        if (!$this->user()->email) {
            throw ValidationException::withMessages([
                'social_email' => 'Your email address must be registered to disconnect your social account.',
            ]);
        }

        if (is_null($this->user()->password)) {
            throw ValidationException::withMessages([
                'social_password' => 'Your password must be registered to disconnect your social account.',
            ]);
        }
    }
}