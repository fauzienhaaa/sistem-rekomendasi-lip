<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UndertoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $undertones = [
            ['name' => 'Warm-Shade'],
            ['name' => 'Cool-Shade'],
            ['name' => 'Neutral-Shade'],
        ];

        foreach ($undertones as $undertone) {
            \App\Models\Undertone::create($undertone);
        }
    }
}
