<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Undertone;

class UndertoneController extends Controller
{
    public function index()
    {
        $undertones = Undertone::latest()->paginate(10);
        return view('admin.undertones.index', compact('undertones'));
    }

    public function create()
    {
        $undertone = new Undertone();
        return view('admin.undertones.form', compact('undertone'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Undertone::create($validated);

        return redirect()->route('admin.undertones.index')
            ->with('success', 'Undertone berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $undertone = Undertone::findOrFail($id);
        return view('admin.undertones.form', compact('undertone'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $undertone = Undertone::findOrFail($id);
        $undertone->update($validated);

        return redirect()->route('admin.undertones.index')
            ->with('success', 'Undertone berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $undertone = Undertone::findOrFail($id);
        
        // Cek relasi pivot
        if($undertone->products()->count() > 0) {
            return redirect()->route('admin.undertones.index')
                ->with('error', 'Gagal menghapus! Undertone ini masih terhubung dengan beberapa produk. Hapus keterkaitan di produk terlebih dahulu.');
        }

        $undertone->delete();

        return redirect()->route('admin.undertones.index')
            ->with('success', 'Undertone berhasil dihapus!');
    }
}
