<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

use App\Models\User;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(2)
            ->state(new Sequence([
                'email' => 'user@gmail.com',
                'password' => 'testuser'
            ], [
                'email' => 'user2@gmail.com',
                'password' => 'testuser2'
            ]))
            ->create();
    }
}
