<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;

use App\Models\Brand;
use App\Models\Type;
use App\Models\LipCondition;
use App\Models\Undertone;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = fopen(base_path('Produk Lip.csv'), 'r');
        $isFirstRow = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            if (!isset($data[0]) || empty(trim($data[0]))) {
                continue;
            }

            $brandName = trim($data[0]);
            $productName = trim($data[1]);
            $variantName = isset($data[2]) ? trim($data[2]) : '';
            $typeName = isset($data[3]) ? trim($data[3]) : 'Unknown';
            $lipConditionsStr = isset($data[4]) ? trim($data[4]) : '';
            $undertonesStr = isset($data[5]) ? trim($data[5]) : '';
            $longLasting = !empty(trim($data[6])) ? trim($data[6]) : 'High-Stay';
            $finish = isset($data[7]) && !empty(trim($data[7])) ? trim($data[7]) : 'Matte';
            $price = isset($data[8]) && !empty(trim($data[8])) ? trim($data[8]) : '38500';

            $brand = Brand::firstOrCreate(['name' => $brandName]);
            $type = Type::firstOrCreate(['name' => $typeName]);

            $fullName = $variantName !== '' ? $productName . ' - ' . $variantName : $productName;

            $product = Products::create([
                'brand_id' => $brand->id,
                'type_id' => $type->id,
                'name' => $fullName,
                'description' => null,
                'image_path' => null,
                'finish' => $finish,
                'long_lasting' => $longLasting,
                'price' => $price
            ]);

            if ($lipConditionsStr !== '') {
                $conditionsArray = array_map('trim', explode(',', $lipConditionsStr));
                foreach ($conditionsArray as $condName) {
                    $lipCondition = LipCondition::where('name', $condName)->first();
                    if ($lipCondition) {
                        $product->lipConditions()->attach($lipCondition->id);
                    }
                }
            }

            if ($undertonesStr !== '') {
                $undertonesArray = array_map('trim', explode(',', $undertonesStr));
                foreach ($undertonesArray as $utName) {
                    $normalizedUtName = str_replace(' ', '-', $utName);
                    $undertone = Undertone::where('name', $normalizedUtName)->first();
                    if ($undertone) {
                        $product->undertones()->attach($undertone->id);
                    }
                }
            }
        }

        fclose($csvFile);
    }
}