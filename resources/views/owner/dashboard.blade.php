<x-app-layout>
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Laporan Transaksi & Stok</h2>
            <p class="text-sm text-gray-500 mt-1">Ringkasan performa operasional seluruh Cabang hari ini.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
                <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <a href="{{ route('owner.reports.transactions') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Transaksi</div>
                <div class="text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
            </div>
            <div class="flex items-end space-x-3">
                <div class="text-3xl font-bold text-gray-900">{{ $totalTransactions }}</div>
                <div class="text-sm font-bold text-emerald-500 flex items-center pb-1">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    12%
                </div>
            </div>
            <div class="text-xs text-gray-400 mt-2 font-medium">Dibandingkan kemarin</div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Omset Harian</div>
                <div class="text-emerald-600 bg-emerald-50 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-end space-x-3">
                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($dailyOmset / 1000000, 1, ',', '.') }}M</div>
                <div class="text-sm font-bold text-emerald-500 flex items-center pb-1">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    8.4%
                </div>
            </div>
            <div class="text-xs text-gray-400 mt-2 font-medium">Target tercapai: 92%</div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok Kritis</div>
                <div class="text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="flex items-end space-x-3">
                <div class="text-3xl font-bold text-red-600">{{ $criticalStocksCount }}</div>
                <div class="text-sm font-bold text-red-600 flex items-center pb-1">
                    ! Perlu Restock
                </div>
            </div>
            <div class="text-xs text-gray-400 mt-2 font-medium">Produk habis segera diproses</div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Efektivitas Staff</div>
                <div class="text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <div class="flex items-end space-x-3">
                <div class="text-3xl font-bold text-gray-900">98.2%</div>
                <div class="text-sm font-bold text-emerald-500 flex items-center pb-1">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Stabil
                </div>
            </div>
            <div class="text-xs text-gray-400 mt-2 font-medium">KPI Rata-rata Tim</div>
        </div>
    </div>

    <!-- Tables Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (Tables) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Transactions Table -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-sm font-semibold text-gray-700">Laporan Transaksi Harian</h3>
                    <a href="{{ route('owner.reports.transactions') }}" class="text-xs font-medium text-slate-600 bg-white border border-slate-200 shadow-sm hover:bg-slate-50 px-3 py-1.5 rounded flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Lihat Semua
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Jumlah Item</th>
                                <th class="px-6 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total Harga</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentTransactions as $trx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-600">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}, {{ $trx->created_at->format('H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-indigo-700">TXN-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-500 text-center">{{ $trx->details->sum('quantity') }} Items</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-900 text-right">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 inline-flex text-[10px] leading-4 font-bold rounded-full bg-emerald-100 text-emerald-700">COMPLETED</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                            @if($recentTransactions->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm font-medium text-gray-500">Belum ada transaksi terbaru.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Stocks Table -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-sm font-semibold text-gray-700">Laporan Stok & Inventaris</h3>
                    <div class="flex items-center text-xs font-bold text-red-600">
                        <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
                        {{ $criticalStocksCount }} KRITIS
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Cabang</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($criticalStockItems->take(4) as $stock)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-indigo-50 text-indigo-500 rounded flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-xs font-bold text-gray-900">{{ $stock->product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-600">{{ $stock->branch->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900 text-center font-medium">{{ $stock->stock }} Pcs</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($stock->stock == 0)
                                    <span class="px-2.5 py-1 inline-flex text-[10px] leading-4 font-bold rounded-full bg-red-100 text-red-700 uppercase tracking-wider">Habis</span>
                                    @else
                                    <span class="px-2.5 py-1 inline-flex text-[10px] leading-4 font-bold rounded-full bg-rose-100 text-rose-700 uppercase tracking-wider">Restock</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($criticalStockItems->isEmpty())
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm font-medium text-gray-500">Semua stok dalam keadaan aman.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column (Action Panels) -->
        <div class="space-y-6">
            <!-- Restock Alert Panel -->
            <div class="bg-slate-900 rounded-xl shadow-lg p-6 relative overflow-hidden h-64 flex flex-col justify-between">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-blue-500 rounded-full opacity-20 blur-2xl pointer-events-none"></div>
                <div>
                    <h3 class="text-sm font-bold text-white mb-2 relative z-10">Pesanan Restock Segera</h3>
                    <p class="text-xs text-slate-300 mb-6 relative z-10 leading-relaxed font-medium">
                        Ada {{ $criticalStocksCount }} item yang di bawah ambang batas minimum. Proses pesanan restock ke pusat sekarang untuk menghindari kekosongan stok.
                    </p>
                </div>
                <div class="relative z-10">
                    <button class="w-full bg-emerald-400 hover:bg-emerald-500 text-slate-900 font-bold py-3 px-4 rounded-lg shadow transition-colors flex justify-between items-center text-sm">
                        Buat Pesanan Restock
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Insight Panel -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-6">
                <div class="flex items-center text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Insight Cabang
                </div>
                <h4 class="font-bold text-xs text-slate-800 mb-4">Produk Terlaris Minggu Ini:</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-medium text-slate-600">Telur Ayam Negeri 10btr</span>
                        <span class="text-xs font-bold text-slate-900">428 Unit</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-medium text-slate-600">Beras Premium 5kg</span>
                        <span class="text-xs font-bold text-slate-900">312 Unit</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-medium text-slate-600">Gula Pasir 1kg</span>
                        <span class="text-xs font-bold text-slate-900">295 Unit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>