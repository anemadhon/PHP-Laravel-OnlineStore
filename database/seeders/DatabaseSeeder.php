<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StoreSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            StoreSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class
        ]);
    }
}
