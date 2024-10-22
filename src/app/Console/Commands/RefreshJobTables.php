<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RefreshJobTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-job-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = [
            'jobs',
            'failed_jobs'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Table {$table} has been truncated.");
        }

        Artisan::call('cache:clear');
        $this->info('Cache clear successfully.');

        Artisan::call('config:clear');
        $this->info('config clear successfully.');
    }
}