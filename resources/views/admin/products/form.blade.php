@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Produk' : ' uk')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-gray-800">
                {{ $product->exists ? 'Edit Produk: ' . $product->name : 'Tambah Produk Baru' }}</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi form di bawah ini untuk menyimpan data produk.</p>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ $product->exists ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if($product->exists)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Dasar -->
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Informasi Dasar</h3>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required
                            min="0"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                    </div>

                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Brand <span
                                class="text-red-500">*</span></label>
                        <select name="brand_id" id="brand_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2 bg-white">
                            <option value="">-- Pilih Brand --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipe Produk <span
                                class="text-red-500">*</span></label>
                        <select name="type_id" id="type_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2 bg-white">
                            <option value="">-- Pilih Tipe --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_id', $product->type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Karakteristik -->
                    <div class="col-span-1 md:col-span-2 mt-4">
                        <h3 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Karakteristik Produk</h3>
                    </div>

                    <div>
                        <label for="finish" class="block text-sm font-medium text-gray-700 mb-1">Finish (Hasil Akhir) <span
                                class="text-red-500">*</span></label>
                        <select name="finish" id="finish" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2 bg-white">
                            <option value="">-- Pilih Finish --</option>
                            @foreach(['Matte', 'Glossy', 'Satin/Velvet'] as $finish)
                                <option value="{{ $finish }}" {{ old('finish', $product->finish) == $finish ? 'selected' : '' }}>
                                    {{ $finish }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="long_lasting" class="block text-sm font-medium text-gray-700 mb-1">Ketahanan (Long
                            Lasting) <span class="text-red-500">*</span></label>
                        <select name="long_lasting" id="long_lasting" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2 bg-white">
                            <option value="">-- Pilih Ketahanan --</option>
                            @foreach(['High-Stay', 'Low-Stay'] as $stay)
                                <option value="{{ $stay }}" {{ old('long_lasting', $product->long_lasting) == $stay ? 'selected' : '' }}>{{ $stay }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Detail Tambahan -->
                    <div class="col-span-1 md:col-span-2 mt-4">
                        <h3 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Detail Tambahan</h3>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar Produk</label>
                        @if($product->image_path)
                            <div class="mb-3">
                                <img src="{{ Storage::url($product->image_path) }}" alt="Preview" class="h-24 w-24 object-cover rounded-md border border-gray-200">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2 bg-white">
                        <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi
                            Produk</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Relasi / Kriteria Rekomendasi -->
                    <div class="col-span-1 md:col-span-2 mt-4">
                        <h3 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Kriteria Kecocokan (Multiple
                            Choice)</h3>
                    </div>

                    <!-- Checkboxes Kondisi Bibir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Cocok Untuk Kondisi Bibir:</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto p-3 border rounded-md bg-gray-50">
                            @php
                                $selectedLipConditions = old('lip_conditions', $product->exists ? $product->lipConditions->pluck('id')->toArray() : []);
                            @endphp
                            @forelse($lipConditions as $lc)
                                <div class="flex items-center">
                                    <input id="lc_{{ $lc->id }}" name="lip_conditions[]" type="checkbox" value="{{ $lc->id }}"
                                        {{ in_array($lc->id, $selectedLipConditions) ? 'checked' : '' }}
                                        class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300 rounded rounded-sm">
                                    <label for="lc_{{ $lc->id }}" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                        {{ $lc->name }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-sm text-red-500">Data Master Kondisi Bibir masih kosong!</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Checkboxes Undertone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Cocok Untuk Undertone:</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto p-3 border rounded-md bg-gray-50">
                            @php
                                $selectedUndertones = old('undertones', $product->exists ? $product->undertones->pluck('id')->toArray() : []);
                            @endphp
                            @forelse($undertones as $ut)
                                <div class="flex items-center">
                                    <input id="ut_{{ $ut->id }}" name="undertones[]" type="checkbox" value="{{ $ut->id }}" {{ in_array($ut->id, $selectedUndertones) ? 'checked' : '' }}
                                        class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300 rounded rounded-sm">
                                    <label for="ut_{{ $ut->id }}" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                        {{ $ut->name }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-sm text-red-500">Data Master Undertone masih kosong!</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                        {{ $product->exists ? 'Simpan Perubahan' : 'Simpan Produk' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection