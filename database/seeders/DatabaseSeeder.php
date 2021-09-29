<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.net',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'username' => 'admin',
            'role' => 'ADMIN',
            'phone_number' => '08133',
            'address_one' => 'Bumi',
            'address_two' => 'Bumi',
            'provincy' => 'Indah',
            'regency' => 'Indah',
            'zip_code' => '12300',
            'country' => 'IDN'
        ]);
        
        User::create([
            'name' => 'Owner Store',
            'email' => 'owner@store.net',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'username' => 'owner',
            'role' => 'USER',
            'has_store' => 1,
            'phone_number' => '08133',
            'address_one' => 'Bumi',
            'address_two' => 'Bumi',
            'provincy' => 'Indah',
            'regency' => 'Indah',
            'zip_code' => '12300',
            'country' => 'IDN'
        ]);

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class
        ]);
    }
}
