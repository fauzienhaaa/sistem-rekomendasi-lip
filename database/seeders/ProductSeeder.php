<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $knowledgeBase = [
            [
                'name' => 'SuperStay Matte Ink',
                'brand' => 'Maybelline',
                'type' => 'Lip Cream',
                'description' => 'Tahan lama hingga 16 jam, cocok untuk bibir normal dan warna kulit warm.',
                'target_undertone' => 'warm',
                'finish' => 'matte',
                'lip_condition' => 'normal',
            ],
            [
                'name' => 'Gloss Bomb Universal',
                'brand' => 'Fenty Beauty',
                'type' => 'Lip Gloss',
                'description' => 'Memberikan kilau maksimal dan melembapkan bibir kering. Cocok untuk semua undertone.',
                'target_undertone' => 'neutral',
                'finish' => 'glossy',
                'lip_condition' => 'dry',
            ],
            [
                'name' => 'Velvet Lip Tint',
                'brand' => '3CE',
                'type' => 'Lip Tint',
                'description' => 'Tekstur halus menyamarkan garis bibir gelap, cocok untuk undertone cool.',
                'target_undertone' => 'cool',
                'finish' => 'velvet',
                'lip_condition' => 'dark_lips',
            ],
            [
                'name' => 'Butter Rush Lip Cream',
                'brand' => 'Wardah',
                'type' => 'Lip Cream',
                'description' => 'Matte tapi melembapkan, menutupi bibir gelap dengan baik untuk undertone warm.',
                'target_undertone' => 'warm',
                'finish' => 'matte',
                'lip_condition' => 'dark_lips',
            ],
        ];

        foreach ($knowledgeBase as $item) {
            Products::create($item);
        }
    }
}
