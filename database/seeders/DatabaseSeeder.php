<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Table;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::updateOrCreate(['email' => 'cashier@example.com'], [
            'name' => 'Cashier User',
            'role' => 'cashier',
            'password' => Hash::make('cashier'),
        ]);

        foreach (['Table 1', 'Table 2', 'Table 3'] as $tableName) {
            Table::updateOrCreate(
                ['table_name' => $tableName],
                ['status' => 'available']
            );
        }
    }
}
