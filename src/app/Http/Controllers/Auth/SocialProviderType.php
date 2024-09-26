<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

enum SocialProviderType: string
{
    case X = 'x';
    case Google = 'google';
    case GoogleAdmin = 'google-admin';
}