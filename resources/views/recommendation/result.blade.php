<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 p-10 font-sans">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-md mb-6">
            <h1 class="text-2xl font-bold text-pink-600 mb-2">Hasil Analisis Sistem</h1>
            <p class="text-gray-600">Berdasarkan profil: Undertone <b>{{ ucfirst($request->undertone) }}</b>, Bibir <b>{{ str_replace('_', ' ', ucfirst($request->lip_condition)) }}</b>, Hasil <b>{{ ucfirst($request->finish) }}</b>.</p>
        </div>

        @if($recommendations->isEmpty())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                Maaf, saat ini belum ada produk di database kami yang 100% cocok dengan kriteria spesifik Anda. Coba ubah sedikit preferensi Anda!
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($recommendations as $product)
                    <div class="bg-white p-6 rounded-lg shadow border-t-4 border-pink-400">
                        <span class="text-xs font-bold bg-pink-100 text-pink-800 px-2 py-1 rounded">{{ $product->type }}</span>
                        <h2 class="text-xl font-bold mt-2">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-500 mb-4">Oleh {{ $product->brand }}</p>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('recommendation.form') }}" class="text-pink-500 font-bold hover:underline">&larr; Coba Lagi</a>
        </div>
    </div>
</body>
</html>