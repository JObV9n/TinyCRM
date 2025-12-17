<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class checkdb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database connection!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Check database connection
        try {
            \DB::connection()->getPdo();
            $this->info('Database is connected: ' . \DB::connection()->getDatabaseName());
        } catch (\Exception $e) {
            $this->error('Database connection failed: ' . $e->getMessage());
            \Log::error('Database connection failed: ' . $e->getMessage());
            return 1; // Exit with an error code
        }
    }
}
