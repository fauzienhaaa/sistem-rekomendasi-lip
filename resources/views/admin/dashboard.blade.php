@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Riwayat Rekomendasi Sistem</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar riwayat pencarian lipstik dari pengunjung (Knowledge-Based).
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-700 font-medium border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Undertone</th>
                        <th class="px-6 py-4">Kondisi Bibir</th>
                        <th class="px-6 py-4">Finish</th>
                        <th class="px-6 py-4">Ketahanan</th>
                        <th class="px-6 py-4">Budget</th>
                        <th class="px-6 py-4 text-center">Rekomendasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($histories as $history)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $history->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4"><span
                                    class="inline-flex px-2 py-1 text-gray-500 text-xs">{{ $history->criteria_undertone ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4"><span
                                    class="inline-flex px-2 py-1 text-gray-500 text-xs">{{ $history->criteria_lip_condition ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4"><span
                                    class="inline-flex px-2 py-1 text-gray-500 text-xs">{{ $history->criteria_finish ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4"><span
                                    class="inline-flex px-2 py-1 text-gray-500 text-xs">{{ $history->criteria_long_lasting ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4"><span
                                    class="inline-flex px-2 py-1 text-gray-500 text-xs">{{ $history->criteria_price_range ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button"
                                    onclick="openProductModal('{{ addslashes($history->result_product_name) }}')"
                                    class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-100 rounded-md hover:bg-rose-100 transition-colors text-xs font-medium focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Hasil
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                    </svg>
                                    <p>Belum ada riwayat rekomendasi dari pengunjung.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($histories->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $histories->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Rekomendasi Produk -->
    <div id="productModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 transform transition-all scale-95 opacity-0"
            id="productModalContent">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    Hasil Rekomendasi
                </h3>
                <button onclick="closeProductModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-500 mb-2">Produk yang disarankan sistem:</p>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-left max-h-64 overflow-y-auto">
                    <div id="modalProductName" class="text-sm text-gray-700 leading-relaxed pl-2">
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-xl flex justify-end">
                <button onclick="closeProductModal()"
                    class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Vanilla JS untuk Modal
        const modal = document.getElementById('productModal');
        const modalContent = document.getElementById('productModalContent');
        const productNameEl = document.getElementById('modalProductName');

        function openProductModal(productName) {
            // Tampilkan sebagai list-disc
            if (productName === 'Tidak Ditemukan' || !productName) {
                productNameEl.innerHTML = '<span class="italic text-gray-400">Tidak Ditemukan</span>';
            } else {
                const products = productName.split(', ');
                let listHtml = '<ul class="list-disc list-inside space-y-1">';
                products.forEach(item => {
                    listHtml += `<li>${item}</li>`;
                });
                listHtml += '</ul>';
                productNameEl.innerHTML = listHtml;
            }

            // Tampilkan modal (hapus hidden)
            modal.classList.remove('hidden');

            // Animasi pop (delay sedikit agar transition jalan)
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeProductModal() {
            // Balikkan animasi
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            // Sembunyikan setelah animasi selesai
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Tutup jika klik area luar modal
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeProductModal();
            }
        });
    </script>
@endsection