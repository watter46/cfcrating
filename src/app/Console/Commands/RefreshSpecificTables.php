<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RefreshSpecificTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-specific-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh specific tables and run corresponding seeders, excluding users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = [
            'game_player',
            'game_user',
            'games',
            'players',
            'ratings',
            'users_ratings'
        ];

        // 削除処理
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Table {$table} has been truncated.");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seeder実行処理
        $this->call('db:seed', ['--class' => 'InsertSeeder']);

        $this->info('Specific tables have been refreshed and seeders executed successfully.');

        return 0;
    }
}