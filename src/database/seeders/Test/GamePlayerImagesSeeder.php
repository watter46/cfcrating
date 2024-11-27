<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GamePlayerImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::fake('public');

        Storage::disk('public')->makeDirectory('image/player');
        
        $playerIds = [
            18959,
            161907,
            22094,
            152953,
            47380,
            116117,
            5996,
            136723,
            152982,
            63577,
            283058,
            1864,
            583,
            148099,
            336671,
            269
        ];

        foreach ($playerIds as $playerId) {
            $realFilePath = storage_path("app/public/image/player/$playerId.png");

            Storage::disk('public')->put("image/player/$playerId.png", file_get_contents($realFilePath));
        }
    }
}
