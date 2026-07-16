<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Arimbi Kosmetik - Rekomendasi Lip Product</title>
    <!-- Favicon & Thumbnail (Open Graph) -->
    <link rel="icon" type="image/png" href="{{ asset('logo_arimbi.webp') }}">
    <meta property="og:title" content="Arimbi Kosmetik - Rekomendasi Lip Product">
    <meta property="og:description" content="Temukan lipstik yang 100% cocok untuk kondisi bibir dan undertone Anda!">
    <meta property="og:image" content="{{ asset('logo_arimbi.webp') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Lexend"', 'sans-serif'],
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
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .input-premium {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-rose-50 via-pink-50 to-rose-100 min-h-screen p-6 md:p-10 font-sans text-gray-800 selection:bg-rose-200">

    <div
        class="max-w-2xl mx-auto glass-panel p-8 md:p-10 rounded-3xl shadow-xl shadow-rose-900/5 mt-8 border-t border-white">

        <div class="text-center mb-8">
            <span class="text-rose-400 font-semibold tracking-wider uppercase text-xs mb-2 block">Arimbi Kosmetik</span>
            <h1 class="text-3xl font-semibold text-gray-800 mb-2">Cari Lip Product Sesuai Kondisimu!</h1>
            <p class="text-gray-500 text-sm">Temukan lipstik, liptint, atau lipcream impian yang paling pas untuk
                bibirmu.</p>
        </div>

        <!-- Jika ada pesan error validasi, tampilkan di sini -->
        @if ($errors->any())
            <div
                class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-xl relative mb-8 flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 mt-0.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <div>
                    <strong class="font-semibold block mb-1">Oops, ada yang terlewat!</strong>
                    <span class="text-sm">Pastikan semua pilihan (1 sampai 5) sudah diisi dengan benar.</span>
                </div>
            </div>
        @endif

        <form action="{{ route('recommendation.process') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Kondisi Bibir -->
            <div class="group">
                <label
                    class="block font-medium text-gray-700 mb-2 ml-1 transition-colors group-focus-within:text-rose-500">1.
                    Bagaimana kondisi bibirmu saat ini?</label>
                <select name="kondisi_bibir"
                    class="input-premium w-full p-3.5 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 transition-all text-gray-700">
                    <option value="" disabled selected>Pilih Kondisi Bibir...</option>
                    @foreach($lipConditions as $condition)
                        <option value="{{ $condition }}">{{ $condition }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Kesesuaian Warna -->
            <div class="group">
                <label
                    class="block font-medium text-gray-700 mb-2 ml-1 transition-colors group-focus-within:text-rose-500">2.
                    Apa undertone atau kesesuaian warna kulitmu?</label>
                <select name="kesesuaian_warna"
                    class="input-premium w-full p-3.5 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 transition-all text-gray-700">
                    <option value="" disabled selected>Pilih Undertone/Warna...</option>
                    @foreach($undertones as $undertone)
                        <option value="{{ $undertone }}">{{ $undertone }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 3. Tekstur & Finish -->
            <div class="group">
                <label
                    class="block font-medium text-gray-700 mb-2 ml-1 transition-colors group-focus-within:text-rose-500">3.
                    Hasil akhir (finish) seperti apa yang kamu suka?</label>
                <select name="tekstur_finish"
                    class="input-premium w-full p-3.5 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 transition-all text-gray-700">
                    <option value="" disabled selected>Pilih Hasil Akhir...</option>
                    @foreach($finishes as $finish)
                        <option value="{{ $finish }}">{{ $finish }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 4. Ketahanan (Durasi) -->
            <div class="group">
                <label
                    class="block font-medium text-gray-700 mb-2 ml-1 transition-colors group-focus-within:text-rose-500">4.
                    Seberapa lama ketahanan yang kamu butuhkan?</label>
                <select name="ketahanan"
                    class="input-premium w-full p-3.5 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 transition-all text-gray-700">
                    <option value="" disabled selected>Pilih Ketahanan...</option>
                    @foreach($longLastings as $lasting)
                        <option value="{{ $lasting }}">{{ str_replace('-', ' ', $lasting) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 5. Rentang Harga -->
            <div class="group">
                <label
                    class="block font-medium text-gray-700 mb-2 ml-1 transition-colors group-focus-within:text-rose-500">5.
                    Berapa budget yang kamu siapkan?</label>
                <select name="rentang_harga"
                    class="input-premium w-full p-3.5 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 transition-all text-gray-700">
                    <option value="" disabled selected>Pilih Rentang Harga...</option>
                    @foreach($priceRanges as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-rose-400 to-pink-500 text-white font-semibold py-4 rounded-xl shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50 hover:from-rose-500 hover:to-pink-600 transform hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98] transition-all duration-200 tracking-wide">
                    Dapatkan Rekomendasi ✨
                </button>
            </div>
        </form>
    </div>
</body>

</html>