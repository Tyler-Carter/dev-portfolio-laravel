<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Notes:
     * - Supports both MySQL and Postgres (Neon).
     * - Does not silently swallow errors (so CI/Render will show failures).
     * - Uses FK-safe truncation strategy per driver.
     */
    public function run(): void
    {
        // Optional: clear log (keep, but don't block seeding if it fails)
        try {
            @file_put_contents(storage_path('logs/laravel.log'), '');
        } catch (\Throwable $th) {
            Log::error('Failed to clear laravel.log', ['error' => $th->getMessage()]);
        }

        $driver = DB::getDriverName();

        try {
            // Truncate all tables except migrations, in a way that works per driver
            $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
            $tables = array_values(array_filter($tables, static fn ($t) => $t !== 'migrations'));

            if (!empty($tables)) {
                if ($driver === 'pgsql') {
                    // Postgres: truncate all tables with CASCADE, restart identities
                    $quoted = implode(', ', array_map(static fn ($t) => '"' . $t . '"', $tables));
                    DB::statement("TRUNCATE TABLE {$quoted} RESTART IDENTITY CASCADE");
                } else {
                    // MySQL: disable FK checks, truncate per table
                    if ($driver === 'mysql') {
                        DB::statement('SET FOREIGN_KEY_CHECKS=0');
                    }

                    foreach ($tables as $table) {
                        DB::table($table)->truncate();
                    }

                    if ($driver === 'mysql') {
                        DB::statement('SET FOREIGN_KEY_CHECKS=1');
                    }
                }
            }

            $this->call([
                AdminSeeder::class,
                PortfolioSeeder::class,
            ]);
        } catch (\Throwable $th) {
            Log::error('Database seeding failed', [
                'driver' => $driver,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Critical: rethrow so `php artisan db:seed` fails visibly instead of "success"
            throw $th;
        }
    }
}
