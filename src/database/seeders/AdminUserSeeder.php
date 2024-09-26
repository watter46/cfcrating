<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Http\Controllers\Auth\RoleType;
use App\Http\Controllers\Auth\SocialProviderType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin1',
            'role' => RoleType::Admin->value,
            'provider' => SocialProviderType::Google->value,
            'provider_id' => env('ADMIN_PROVIDER_ID'),
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
        ]);
    }
}