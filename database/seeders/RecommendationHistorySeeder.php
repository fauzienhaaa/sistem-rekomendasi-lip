<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RecommendationHistory;

class RecommendationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $histories = [
            [
                'criteria_undertone' => 'Warm',
                'criteria_lip_condition' => 'Bibir Kering',
                'criteria_finish' => 'Matte',
                'criteria_long_lasting' => 'High-Stay',
                'criteria_price_range' => 'Ekonomis',
                'result_product_name' => 'Wardah Colorfit Velvet Matte Lip Mousse',
                'created_at' => now()->subMinutes(10),
            ],
            [
                'criteria_undertone' => 'Cool',
                'criteria_lip_condition' => 'Bibir Gelap',
                'criteria_finish' => 'Glossy',
                'criteria_long_lasting' => 'Low-Stay',
                'criteria_price_range' => 'Standar',
                'result_product_name' => 'Make Over Intense Matte Lip Cream',
                'created_at' => now()->subHours(2),
            ],
            [
                'criteria_undertone' => 'Neutral',
                'criteria_lip_condition' => 'Normal',
                'criteria_finish' => 'Velvet',
                'criteria_long_lasting' => 'High-Stay',
                'criteria_price_range' => 'Ekonomis',
                'result_product_name' => 'Emina Creamatte',
                'created_at' => now()->subDays(1),
            ],
            [
                'criteria_undertone' => 'Warm',
                'criteria_lip_condition' => 'Bibir Kering',
                'criteria_finish' => 'Matte',
                'criteria_long_lasting' => 'Low-Stay',
                'criteria_price_range' => 'Premium',
                'result_product_name' => 'Somethinc Idol Blurry Soft Lip Matte',
                'created_at' => now()->subDays(2),
            ],
            [
                'criteria_undertone' => 'Cool',
                'criteria_lip_condition' => 'Bibir Pecah-pecah',
                'criteria_finish' => 'Glossy',
                'criteria_long_lasting' => 'High-Stay',
                'criteria_price_range' => 'Standar',
                'result_product_name' => 'Hanasui Mattedorable Lip Cream',
                'created_at' => now()->subDays(3),
            ],
        ];

        foreach ($histories as $history) {
            RecommendationHistory::create($history);
        }
    }
}
