<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LipConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            ['name' => 'Kering'],
            ['name' => 'Normal'],
            ['name' => 'Dehidrasi'],
        ];

        foreach ($conditions as $condition) {
            \App\Models\LipCondition::create($condition);
        }
    }
}
