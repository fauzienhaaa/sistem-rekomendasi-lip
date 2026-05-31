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
        // 1. VALIDASI: Menyesuaikan dengan 5 variabel dan nilai (value) dari GForm
        $request->validate([
            'kondisi_bibir' => 'required|string',
            'kesesuaian_warna' => 'required|string',
            'tekstur_finish' => 'required|string',
            'ketahanan' => 'required|string',
            'rentang_harga' => 'required|string',
        ]);

        // 2. INFERENCE ENGINE: Mencari kecocokan berdasarkan rule GForm
        $query = Products::query();

        // Kita bungkus kondisinya (closure) agar pencarian SQL tetap akurat dan tidak bocor
        $query->where(function ($q) use ($request) {

            // Filter 1: Kondisi Bibir (Menembus relasi Pivot)
            $q->whereHas('lipConditions', function ($subQuery) use ($request) {
                $subQuery->where('name', $request->kondisi_bibir);
            });

            // Filter 2: Kesesuaian Warna (Pencocokan Persis)
            $q->whereHas('undertones', function ($subQuery) use ($request) {
                $subQuery->where('name', $request->kesesuaian_warna);
            });

            // Filter 3: Tekstur & Finish
            // Menggunakan LIKE karena di CSV ada data "Satin/Velvet" dan form mengirim "Velvet"
            $q->where('finish', 'LIKE', '%' . $request->tekstur_finish . '%');

            // Filter 4: Ketahanan
            $q->where('long_lasting', $request->ketahanan);

            // Filter 5: Rentang Harga (Mapping dari String ke rentang Angka Price)
            if ($request->rentang_harga === 'Ekonomis') {
                $q->whereRaw('CAST(price AS UNSIGNED) <= 35000');
            } elseif ($request->rentang_harga === 'Standar') {
                $q->whereRaw('CAST(price AS UNSIGNED) > 35000')->whereRaw('CAST(price AS UNSIGNED) <= 75000');
            } elseif ($request->rentang_harga === 'Premium') {
                $q->whereRaw('CAST(price AS UNSIGNED) > 75000');
            }

        });

        // Ambil hasil rekomendasi dengan Eager Loading (Mengambil nama Brand & Type sekaligus)
        $recommendations = $query->with(['brand', 'type', 'lipConditions', 'undertones'])->get();

        // 3. LOGGING KE HISTORY DASHBOARD
        // Jika ada hasil, kumpulkan namanya, jika tidak tulis "Tidak Ditemukan"
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