<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class RecommendationController extends Controller
{
    public function index()
    {
        $lipConditions = \App\Models\LipCondition::orderBy('name')->pluck('name');
        $undertones = \App\Models\Undertone::orderBy('name')->pluck('name');

        // Ambil semua finish secara langsung dari database (jangan di-split)
        $finishes = \App\Models\Products::select('finish')
            ->whereNotNull('finish')
            ->distinct()
            ->pluck('finish')
            ->toArray();

        sort($finishes);

        $longLastings = \App\Models\Products::select('long_lasting')->whereNotNull('long_lasting')->distinct()->pluck('long_lasting');

        // Rentang harga kita buat statis karena ini adalah kategori range (bukan data master dari DB)
        $priceRanges = [
            'Ekonomis' => 'Ekonomis (Di bawah Rp35.000)',
            'Standar' => 'Standar (Rp35.000 - Rp75.000)',
            'Premium' => 'Premium (Di atas Rp75.000)'
        ];

        return view('user.recommendation.form', compact('lipConditions', 'undertones', 'finishes', 'longLastings', 'priceRanges'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'kondisi_bibir' => 'nullable|string',
            'kesesuaian_warna' => 'nullable|string',
            'tekstur_finish' => 'nullable|string',
            'ketahanan' => 'nullable|string',
            'rentang_harga' => 'nullable|string',
        ]);
        $products = Products::with(['brand', 'type', 'lipConditions', 'undertones'])->get();

        // Cari harga tertinggi untuk perhitungan selisih harga
        $maxPrice = Products::max('price');
        if (!$maxPrice || $maxPrice == 0)
            $maxPrice = 1;

        $activeCriteriaCount = 0;
        if (!empty($request->kondisi_bibir))
            $activeCriteriaCount++;
        if (!empty($request->kesesuaian_warna))
            $activeCriteriaCount++;
        if (!empty($request->tekstur_finish))
            $activeCriteriaCount++;
        if (!empty($request->ketahanan))
            $activeCriteriaCount++;
        if (!empty($request->rentang_harga))
            $activeCriteriaCount++;

        $recommendations = collect();

        // Jika tidak ada kriteria yang dipilih sama sekali, kembalikan kosong atau semua produk
        if ($activeCriteriaCount == 0) {
            $recommendations = collect();
        } else {
            $weight = 1 / $activeCriteriaCount; // Pembobotan tergantung jumlah kriteria yang diisi

            foreach ($products as $product) {
                $s1 = 0;
                $s2 = 0;
                $s3 = 0;
                $s4 = 0;
                $s5 = 0;

                // S1: Kondisi Bibir
                if (!empty($request->kondisi_bibir) && $product->lipConditions->contains('name', $request->kondisi_bibir)) {
                    $s1 = 1;
                }

                // S2: Kesesuaian Warna
                if (!empty($request->kesesuaian_warna) && $product->undertones->contains('name', $request->kesesuaian_warna)) {
                    $s2 = 1;
                }

                // S3: Tekstur & Finish
                if (!empty($request->tekstur_finish) && stripos($product->finish, $request->tekstur_finish) !== false) {
                    $s3 = 1;
                }

                // S4: Ketahanan
                if (!empty($request->ketahanan) && $product->long_lasting === $request->ketahanan) {
                    $s4 = 1;
                }

                // S5: Rentang Harga
                if (!empty($request->rentang_harga)) {
                    $targetPrice = 0;
                    $inRange = false;
                    $productPrice = (float) $product->price;

                    if ($request->rentang_harga === 'Ekonomis') {
                        $targetPrice = 35000;
                        if ($productPrice <= $targetPrice) {
                            $inRange = true;
                        }
                    } elseif ($request->rentang_harga === 'Standar') {
                        $targetPrice = 75000;
                        if ($productPrice > 35000 && $productPrice <= 75000) {
                            $inRange = true;
                        }
                    } elseif ($request->rentang_harga === 'Premium') {
                        $targetPrice = $maxPrice;
                        if ($productPrice > 75000) {
                            $inRange = true;
                        }
                    }

                    if ($inRange) {
                        $selisih = abs($targetPrice - $productPrice);
                        $s5 = 1 - ($selisih / $maxPrice);
                        if ($s5 < 0)
                            $s5 = 0;
                    }
                }

                // Total Similarity
                $similarityScore = ($weight * $s1) + ($weight * $s2) + ($weight * $s3) + ($weight * $s4) + ($weight * $s5);

                if ($similarityScore > 0) {
                    $product->similarity_score = $similarityScore;
                    $product->match_percentage = round($similarityScore * 100, 2);
                    $recommendations->push($product);
                }
            }

            // Sorting tertinggi ke terendah
            $recommendations = $recommendations->sortByDesc('similarity_score')->values();
        }

        if ($recommendations->count() > 0) {
            $productNames = $recommendations->pluck('name')->implode(', ');
        } else {
            $productNames = 'Tidak Ditemukan';
        }

        \App\Models\RecommendationHistory::create([
            'criteria_undertone' => $request->kesesuaian_warna,
            'criteria_lip_condition' => $request->kondisi_bibir,
            'criteria_finish' => $request->tekstur_finish,
            'criteria_long_lasting' => $request->ketahanan,
            'criteria_price_range' => $request->rentang_harga,
            'result_product_name' => $productNames,
        ]);

        return view('user.recommendation.result', compact('recommendations', 'request'));
    }
}