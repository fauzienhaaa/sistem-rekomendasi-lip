<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Brand;
use App\Models\Type;
use App\Models\LipCondition;
use App\Models\Undertone;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Products::with(['brand', 'type', 'lipConditions', 'undertones'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('type', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Products();
        $brands = Brand::orderBy('name')->get();
        $types = Type::orderBy('name')->get();
        $lipConditions = LipCondition::orderBy('name')->get();
        $undertones = Undertone::orderBy('name')->get();

        return view('admin.products.form', compact('product', 'brands', 'types', 'lipConditions', 'undertones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'type_id' => 'required|exists:types,id',
            'finish' => 'required|string|in:Matte,Glossy,Satin/Velvet',
            'long_lasting' => 'required|string|in:High-Stay,Low-Stay',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'lip_conditions' => 'nullable|array',
            'lip_conditions.*' => 'exists:lip_conditions,id',
            'undertones' => 'nullable|array',
            'undertones.*' => 'exists:undertones,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
        }

        $product = Products::create([
            'brand_id' => $validated['brand_id'],
            'type_id' => $validated['type_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image_path' => $validated['image_path'] ?? null,
            'finish' => $validated['finish'],
            'long_lasting' => $validated['long_lasting'],
            'price' => $validated['price'],
        ]);

        $product->lipConditions()->sync($request->input('lip_conditions', []));
        $product->undertones()->sync($request->input('undertones', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Products::with(['lipConditions', 'undertones'])->findOrFail($id);
        $brands = Brand::orderBy('name')->get();
        $types = Type::orderBy('name')->get();
        $lipConditions = LipCondition::orderBy('name')->get();
        $undertones = Undertone::orderBy('name')->get();

        return view('admin.products.form', compact('product', 'brands', 'types', 'lipConditions', 'undertones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'type_id' => 'required|exists:types,id',
            'finish' => 'required|string|in:Matte,Glossy,Satin/Velvet',
            'long_lasting' => 'required|string|in:High-Stay,Low-Stay',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'lip_conditions' => 'nullable|array',
            'lip_conditions.*' => 'exists:lip_conditions,id',
            'undertones' => 'nullable|array',
            'undertones.*' => 'exists:undertones,id',
        ]);

        $product = Products::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image_path = $path;
        }

        $product->update([
            'brand_id' => $validated['brand_id'],
            'type_id' => $validated['type_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'finish' => $validated['finish'],
            'long_lasting' => $validated['long_lasting'],
            'price' => $validated['price'],
        ]);

        $product->lipConditions()->sync($request->input('lip_conditions', []));
        $product->undertones()->sync($request->input('undertones', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::findOrFail($id);

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
