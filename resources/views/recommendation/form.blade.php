<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pakar Pemilihan Lip Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 p-10 font-sans">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-pink-600 mb-6">Cari Lip Product Sesuai Kondisimu!</h1>
        
        <form action="{{ route('recommendation.process') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block font-semibold mb-2">1. Apa undertone kulitmu?</label>
                <select name="undertone" class="w-full p-2 border rounded" required>
                    <option value="" disabled selected>Pilih Undertone...</option>
                    <option value="warm">Warm (Urat nadi kehijauan)</option>
                    <option value="cool">Cool (Urat nadi kebiruan/ungu)</option>
                    <option value="neutral">Neutral (Campuran)</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block font-semibold mb-2">2. Bagaimana kondisi bibirmu saat ini?</label>
                <select name="lip_condition" class="w-full p-2 border rounded" required>
                    <option value="" disabled selected>Pilih Kondisi Bibir...</option>
                    <option value="normal">Normal / Sehat</option>
                    <option value="dry">Kering / Pecah-pecah</option>
                    <option value="dark_lips">Pinggiran Bibir Gelap</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">3. Hasil akhir (finish) seperti apa yang kamu suka?</label>
                <select name="finish" class="w-full p-2 border rounded" required>
                    <option value="" disabled selected>Pilih Hasil Akhir...</option>
                    <option value="matte">Matte (Tidak mengkilap, tahan lama)</option>
                    <option value="glossy">Glossy (Berkilau, efek bibir penuh)</option>
                    <option value="velvet">Velvet (Halus, semi-matte)</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-pink-500 text-white font-bold py-3 rounded hover:bg-pink-600 transition">
                Dapatkan Rekomendasi
            </button>
        </form>
    </div>
</body>
</html>