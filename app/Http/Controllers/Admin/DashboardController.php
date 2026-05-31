<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecommendationHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $histories = RecommendationHistory::latest()->paginate(10);
        return view('admin.dashboard', compact('histories'));
    }
}
