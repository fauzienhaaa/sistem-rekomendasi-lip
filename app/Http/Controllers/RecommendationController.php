<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class RecommendationController extends Controller
{
    public function index()
    {
        // Menampilkan form pertanyaan
        return view('recommendation.form');
    }

    public function process(Request $request)
    {
        // Validasi input user
        $request->validate([
            'undertone' => 'required|in:warm,cool,neutral',
            'finish' => 'required|in:matte,glossy,velvet',
            'lip_condition' => 'required|in:dry,normal,dark_lips',
        ]);

        // INFERENCE ENGINE: Mencari kecocokan berdasarkan rule
        $query = Products::query();

        // 1. Filter Kondisi Bibir (Prioritas utama untuk kesehatan/tampilan dasar)
        $query->where('lip_condition', $request->lip_condition)
              ->orWhere('lip_condition', 'normal'); // Produk normal biasanya aman

        // 2. Filter Hasil Akhir (Finish)
        $query->where('finish', $request->finish);

        // 3. Filter Undertone (Neutral biasanya cocok untuk semua)
        $query->whereIn('target_undertone', [$request->undertone, 'neutral']);

        // Ambil hasil rekomendasi
        $recommendations = $query->get();

        return view('recommendation.result', compact('recommendations', 'request'));
    }
}