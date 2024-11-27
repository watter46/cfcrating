<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GameTeamImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::fake('public');

        Storage::disk('public')->makeDirectory('image/team');

        $teamIds = [39, 49];

        foreach ($teamIds as $teamId) {
            $realFilePath = storage_path("app/public/image/team/$teamId");

            Storage::disk('public')->put("image/team/$teamId", file_get_contents($realFilePath));
        }
    }
}