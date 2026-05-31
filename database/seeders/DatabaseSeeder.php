<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LipConditionSeeder::class,
            UndertoneSeeder::class,
            ProductSeeder::class,
            AdminSeeder::class,
        ]);
    }
}