<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GameLeagueImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::fake('public');

        Storage::disk('public')->makeDirectory('image/league');

        $realFilePath = storage_path("app/public/image/league/39");

        Storage::disk('public')->put("image/league/39", file_get_contents($realFilePath));
    }
}