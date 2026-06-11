<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Pantauan Transaksi Harian
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header dengan tanggal -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Transaksi Hari Ini</h3>
                        <p class="text-slate-600 mt-1">{{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-600">Total Transaksi</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $transactions->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kasir</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $trx->created_at->format('H:i:s') }}</p>
                                        <p class="text-xs text-slate-500">{{ $trx->created_at->format('d M Y') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                            <span class="text-indigo-700 font-bold text-xs">{{ substr($trx->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ $trx->user->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $trx->user->role }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $trx->details->count() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="space-y-1">
                                        @foreach($trx->details->take(2) as $detail)
                                        <p class="text-slate-700 text-xs">
                                            • {{ $detail->product->name }} ({{ $detail->quantity }})
                                        </p>
                                        @endforeach
                                        @if($trx->details->count() > 2)
                                        <p class="text-slate-500 text-xs italic">+{{ $trx->details->count() - 2 }} item lagi</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="text-lg font-bold text-green-600">
                                        Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="openDetailModal({{ $trx->id }}, {{ json_encode($trx) }})" 
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded hover:bg-indigo-200 transition-colors">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg">Belum ada transaksi hari ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Detail Transaksi -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4 flex justify-between items-center sticky top-0">
                <h3 class="text-white font-bold text-lg">Detail Transaksi</h3>
                <button onclick="closeDetailModal()" class="text-white hover:text-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <div id="modalContent"></div>
                
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <button onclick="closeDetailModal()" class="w-full bg-slate-300 hover:bg-slate-400 text-slate-800 font-bold py-2 px-4 rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDetailModal(id, transaction) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('modalContent');
            
            const detailsHTML = transaction.details.map(d => {
                const unitPrice = d.quantity ? d.subtotal / d.quantity : 0;
                return `
                <tr class="border-b border-slate-100">
                    <td class="py-3 text-slate-900">${d.product.name}</td>
                    <td class="py-3 text-right text-slate-600">${d.quantity}</td>
                    <td class="py-3 text-right text-slate-600">Rp ${new Intl.NumberFormat('id-ID').format(unitPrice)}</td>
                    <td class="py-3 text-right font-semibold text-slate-900">Rp ${new Intl.NumberFormat('id-ID').format(d.subtotal)}</td>
                </tr>
            `;
            }).join('');

            content.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-600">Waktu</p>
                            <p class="font-semibold text-slate-900">${new Date(transaction.created_at).toLocaleString('id-ID')}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Kasir</p>
                            <p class="font-semibold text-slate-900">${transaction.user.name}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-bold text-slate-900 mb-3">Rincian Produk</h4>
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-slate-600 font-semibold">Produk</th>
                                    <th class="px-3 py-2 text-right text-slate-600 font-semibold">Qty</th>
                                    <th class="px-3 py-2 text-right text-slate-600 font-semibold">Harga</th>
                                    <th class="px-3 py-2 text-right text-slate-600 font-semibold">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${detailsHTML}
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-sm text-slate-600 mb-1">Total Pembayaran</p>
                        <p class="text-3xl font-bold text-green-600">Rp ${new Intl.NumberFormat('id-ID').format(transaction.total_amount)}</p>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    </script>
</x-app-layout>
