<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;


enum RoleType: string
{
    case User = 'user';
    case Admin = 'admin';

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }
}