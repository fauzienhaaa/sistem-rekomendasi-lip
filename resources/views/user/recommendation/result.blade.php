<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi - Arimbi Kosmetik</title>
    <!-- Favicon & Thumbnail (Open Graph) -->
    <link rel="icon" type="image/png" href="{{ asset('logo_arimbi.webp') }}">
    <meta property="og:title" content="Hasil Rekomendasi - Arimbi Kosmetik">
    <meta property="og:description" content="Ini dia lipstik yang paling cocok untuk Anda dari Arimbi Kosmetik!">
    <meta property="og:image" content="{{ asset('logo_arimbi.webp') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Lexend"', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lexend', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .product-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
        }

        /* Custom scrollbar for better look */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #fdf8f6;
        }

        ::-webkit-scrollbar-thumb {
            background: #fbcfe8;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #f472b6;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-rose-50 via-pink-50 to-rose-100 min-h-screen p-6 md:p-10 font-sans text-gray-800 selection:bg-rose-200">
    <div class="max-w-7xl mx-auto">

        <!-- Bagian Header & Ringkasan Input User -->
        <div
            class="glass-panel p-8 rounded-3xl shadow-xl shadow-rose-900/5 mb-8 animate-fade-in-up border-t border-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <span class="text-rose-400 font-semibold tracking-wider uppercase text-xs mb-1 block">Arimbi
                        Kosmetik</span>
                    <h1 class="text-3xl font-semibold text-gray-800">Hasil Analisis Sistem</h1>
                </div>
                <div class="hidden md:block">
                    <span
                        class="bg-white/80 border border-rose-100 text-rose-500 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                        {{ $recommendations->count() }} Produk Ditemukan
                    </span>
                </div>
            </div>

            <div class="bg-white/60 p-4 rounded-2xl border border-white">
                <p class="text-gray-500 text-sm mb-3">Preferensi pencarian Anda:</p>
                <div class="flex flex-wrap gap-2">
                    <span
                        class="bg-rose-100/50 text-rose-700 border border-rose-200/50 text-xs font-medium px-3 py-1.5 rounded-lg shadow-sm">👄
                        Bibir:
                        <span class="font-semibold">{{ $request->kondisi_bibir }}</span></span>
                    <span
                        class="bg-rose-100/50 text-rose-700 border border-rose-200/50 text-xs font-medium px-3 py-1.5 rounded-lg shadow-sm">🎨
                        Warna:
                        <span class="font-semibold">{{ $request->kesesuaian_warna }}</span></span>
                    <span
                        class="bg-rose-100/50 text-rose-700 border border-rose-200/50 text-xs font-medium px-3 py-1.5 rounded-lg shadow-sm">✨
                        Finish:
                        <span class="font-semibold">{{ $request->tekstur_finish }}</span></span>
                    <span
                        class="bg-rose-100/50 text-rose-700 border border-rose-200/50 text-xs font-medium px-3 py-1.5 rounded-lg shadow-sm">⏳
                        Ketahanan:
                        <span class="font-semibold">{{ $request->ketahanan }}</span></span>
                    <span
                        class="bg-rose-100/50 text-rose-700 border border-rose-200/50 text-xs font-medium px-3 py-1.5 rounded-lg shadow-sm">💰
                        Budget:
                        <span class="font-semibold">{{ $request->rentang_harga }}</span></span>
                </div>
            </div>
        </div>

        <!-- Bagian Hasil Rekomendasi -->
        @if($recommendations->isEmpty())
            <div class="glass-panel p-10 rounded-3xl shadow-lg text-center animate-fade-in-up"
                style="animation-delay: 0.1s">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-rose-100 mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak ditemukan produk</h3>
                <p class="text-gray-500 max-w-md mx-auto">Maaf, saat ini belum ada produk di database kami yang 100% cocok
                    dengan kombinasi kriteria spesifik Anda. Coba ubah sedikit preferensi Anda!</p>
                <div class="mt-6">
                    <a href="{{ route('recommendation.form') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-rose-400 to-pink-500 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali Cari
                    </a>
                </div>
            </div>
        @else
            @php
                $groupedRecommendations = $recommendations->groupBy(function ($item) {
                    return $item->type->name ?? 'Lainnya';
                });
                $delay = 0.1;
            @endphp

            @foreach($groupedRecommendations as $typeName => $products)
                <details open
                    class="mb-6 rounded-3xl shadow-xl shadow-rose-900/5 overflow-hidden border border-white group animate-fade-in-up glass-panel"
                    style="animation-delay: {{ $delay }}s">
                    @php $delay += 0.1; @endphp
                    <summary
                        class="cursor-pointer bg-white/60 p-5 font-semibold text-gray-800 text-lg flex justify-between items-center group-open:border-b border-rose-100 hover:bg-white/80 transition-all">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center text-sm">💄</span>
                            <span>{{ $typeName }}
                                <span
                                    class="text-xs font-medium text-rose-500 bg-rose-50 px-2.5 py-1 rounded-full ml-2 border border-rose-100 shadow-sm">{{ $products->count() }}
                                    produk</span>
                            </span>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center text-rose-400 group-hover:bg-rose-100 transition-colors">
                            <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </summary>

                    <div class="p-6 bg-white/40">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @php
                                // Kelompokkan berdasarkan nama dasar produk (sebelum tanda '-')
                                $groupedByBaseProduct = $products->groupBy(function ($item) {
                                    $parts = explode('-', $item->name);
                                    return count($parts) > 1 ? trim($parts[0]) : $item->name;
                                });
                            @endphp

                            @foreach($groupedByBaseProduct as $baseName => $variants)
                                @php
                                    $firstProduct = $variants->first();
                                @endphp
                                <div
                                    class="product-card p-6 rounded-2xl shadow-sm hover:shadow-xl border border-white border-t-4 border-t-rose-400 flex flex-col justify-between transform hover:-translate-y-1.5 transition-all duration-300 group/card relative overflow-hidden">

                                    <!-- Subtle gradient bg on hover -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-rose-50/0 to-rose-50/0 group-hover/card:from-rose-50/50 group-hover/card:to-transparent transition-colors duration-300 pointer-events-none">
                                    </div>

                                    <div class="relative z-10 flex-1">
                                        <div class="flex justify-between items-start mb-3">
                                            <span
                                                class="text-[10px] font-semibold bg-rose-100 text-rose-600 px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $typeName }}</span>
                                            <span
                                                class="text-xs font-semibold text-gray-400 bg-gray-50 px-2 py-1 rounded-md border border-gray-100">{{ $firstProduct->brand->name ?? 'Brand' }}</span>
                                        </div>
                                        <h2 class="text-xl font-bold text-gray-800 leading-tight mb-2">{{ $baseName }}</h2>

                                        <!-- Varian Buttons -->
                                        @php
                                            // Cek apakah produk dalam grup ini memiliki varian (memiliki tanda '-')
                                            $hasRealVariants = $variants->contains(function ($v) {
                                                return strpos($v->name, '-') !== false;
                                            });
                                        @endphp

                                        @if($hasRealVariants)
                                            <div class="mt-4 mb-4">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Varian yang
                                                    Cocok ({{ $variants->count() }}):</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($variants as $variant)
                                                        @php
                                                            $variantParts = explode('-', $variant->name);
                                                            if (count($variantParts) <= 1)
                                                                continue; // Skip jika aneh/tidak ada strip
                                                            $variantName = trim(implode('-', array_slice($variantParts, 1)));
                                                        @endphp
                                                        <div class="group/btn relative">
                                                            <a href="{{ $variant->image_path ? Storage::url($variant->image_path) : 'https://placehold.co/600x600?text=' . urlencode($variant->name) }}"
                                                                target="_blank"
                                                                class="inline-block text-xs font-semibold bg-white border border-rose-200 text-rose-600 px-3 py-1.5 rounded-full hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm hover:shadow-md cursor-pointer text-center">
                                                                {{ $variantName }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <!-- Spacer jika tidak ada varian agar jarak tetap proporsional -->
                                            <div class="mt-4 mb-4"></div>
                                        @endif

                                        <p
                                            class="text-gray-500 text-xs leading-relaxed {{ empty($firstProduct->description) ? 'italic opacity-60' : '' }}">
                                            {{ $firstProduct->description ?? 'Tidak ada deskripsi produk.' }}
                                        </p>
                                    </div>

                                    <!-- Bukti Kecocokan (Knowledge Base Rules) -->
                                    <div class="mt-6 pt-4 border-t border-gray-100 relative z-10">
                                        <div class="flex flex-wrap gap-1.5">
                                            <span
                                                class="text-[10px] bg-blue-50 text-blue-700 border border-blue-100/50 px-2 py-1 rounded-md shadow-sm"
                                                title="Kondisi Bibir">
                                                👄 {{ $firstProduct->lipConditions->pluck('name')->implode(', ') }}</span>
                                            <span
                                                class="text-[10px] bg-purple-50 text-purple-700 border border-purple-100/50 px-2 py-1 rounded-md shadow-sm"
                                                title="Undertone">
                                                🎨 {{ $firstProduct->undertones->pluck('name')->implode(', ') }}</span>
                                            <span
                                                class="text-[10px] bg-amber-50 text-amber-700 border border-amber-100/50 px-2 py-1 rounded-md shadow-sm"
                                                title="Hasil Akhir">
                                                ✨ {{ $firstProduct->finish }}</span>
                                            <span
                                                class="text-[10px] bg-teal-50 text-teal-700 border border-teal-100/50 px-2 py-1 rounded-md shadow-sm"
                                                title="Ketahanan">
                                                ⏳ {{ $firstProduct->long_lasting }}</span>
                                            <span
                                                class="text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-100/50 px-2 py-1 rounded-md shadow-sm font-semibold"
                                                title="Harga">
                                                💰 Rp {{ number_format($firstProduct->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>
            @endforeach

            <!-- Tombol Kembali -->
            <div class="mt-10 text-center animate-fade-in-up" style="animation-delay: {{ $delay }}s">
                <a href="{{ route('recommendation.form') }}"
                    class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm text-rose-500 font-medium py-3 px-8 rounded-full shadow-lg shadow-rose-900/5 hover:bg-white hover:text-rose-600 hover:shadow-xl transform hover:-translate-y-0.5 transition-all border border-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Coba Kriteria Lain
                </a>
            </div>
        @endif

    </div>
</body>

</html>