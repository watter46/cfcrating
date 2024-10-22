<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Facades\Hash;

use App\UseCases\Admin\Exception\InvalidAdminKeyException;


class CheckAdminKey
{
    public function checkOrFail(string $key): bool
    {
        if (!Hash::check($key, config('admin-key.key'))) {
            throw new InvalidAdminKeyException;
        }
        
        return true;
    }
}