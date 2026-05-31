@extends('layouts.admin')

@section('title', $brand->exists ? 'Edit Brand' : 'Tambah Brand')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-xl font-bold text-gray-800">{{ $brand->exists ? 'Edit Brand' : 'Tambah Brand Baru' }}</h2>
        <p class="text-sm text-gray-500 mt-1">Lengkapi form di bawah ini untuk menyimpan data brand.</p>
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

        <form action="{{ $brand->exists ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}" method="POST">
            @csrf
            @if($brand->exists)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Brand <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $brand->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                </div>

                <div>
                    <label for="logo_path" class="block text-sm font-medium text-gray-700 mb-1">URL Logo (Opsional)</label>
                    <input type="url" name="logo_path" id="logo_path" value="{{ old('logo_path', $brand->logo_path) }}" placeholder="https://contoh.com/logo-brand.png" class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                    <p class="text-xs text-gray-500 mt-1">Masukkan URL langsung ke gambar logo brand.</p>
                </div>
            </div>

            <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.brands.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                    {{ $brand->exists ? 'Simpan Perubahan' : 'Simpan Brand' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
