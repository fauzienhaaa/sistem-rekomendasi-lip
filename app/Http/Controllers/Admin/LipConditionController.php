<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LipCondition;

class LipConditionController extends Controller
{
    public function index()
    {
        $lipConditions = LipCondition::latest()->paginate(10);
        return view('admin.lip_conditions.index', compact('lipConditions'));
    }

    public function create()
    {
        $lipCondition = new LipCondition();
        return view('admin.lip_conditions.form', compact('lipCondition'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        LipCondition::create($validated);

        return redirect()->route('admin.lip_conditions.index')
            ->with('success', 'Kondisi Bibir berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $lipCondition = LipCondition::findOrFail($id);
        return view('admin.lip_conditions.form', compact('lipCondition'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $lipCondition = LipCondition::findOrFail($id);
        $lipCondition->update($validated);

        return redirect()->route('admin.lip_conditions.index')
            ->with('success', 'Kondisi Bibir berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $lipCondition = LipCondition::findOrFail($id);
        
        // Cek relasi pivot
        if($lipCondition->products()->count() > 0) {
            return redirect()->route('admin.lip_conditions.index')
                ->with('error', 'Gagal menghapus! Kriteria ini masih terhubung dengan beberapa produk. Hapus keterkaitan di produk terlebih dahulu.');
        }

        $lipCondition->delete();

        return redirect()->route('admin.lip_conditions.index')
            ->with('success', 'Kondisi Bibir berhasil dihapus!');
    }
}
