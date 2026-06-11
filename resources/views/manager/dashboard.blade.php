<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">Dashboard Manager</h2>
                    <p class="text-sm text-gray-500 mt-1">Lihat rangkuman transaksi dan stok cabang Anda secara langsung.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 px-4 py-3 border border-slate-200 text-sm text-slate-700">
                    Cabang: <span class="font-semibold text-slate-900">{{ $branchName ?? 'Belum terhubung' }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm" role="alert">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Transaksi Hari Ini</p>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-900">{{ number_format($totalTransactions, 0, ',', '.') }}</div>
                    <p class="mt-2 text-sm text-slate-500">Jumlah transaksi cabang hari ini.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Omset Hari Ini</p>
                        <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">Ringkas</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-900">Rp {{ number_format($dailyOmset, 0, ',', '.') }}</div>
                    <p class="mt-2 text-sm text-slate-500">Pendapatan cabang hari ini.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Stok Kritis</p>
                        <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">Waspada</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-900">{{ number_format($criticalStocksCount, 0, ',', '.') }}</div>
                    <p class="mt-2 text-sm text-slate-500">Produk dengan stok kurang dari 10.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Aksi Cepat</p>
                        <span class="rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700">Manager</span>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('manager.reports.transactions') }}" class="block rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Laporan Transaksi</a>
                        <a href="{{ route('manager.reports.stocks') }}" class="block rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">Laporan Stok</a>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Transaksi Terbaru</h3>
                            <p class="mt-1 text-sm text-slate-500">Transaksi terakhir di cabang Anda.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-100 text-slate-600 uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="px-6 py-3 text-left">Waktu</th>
                                        <th class="px-6 py-3 text-left">Kasir</th>
                                        <th class="px-6 py-3 text-center">Items</th>
                                        <th class="px-6 py-3 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @forelse($recentTransactions as $trx)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-900 font-semibold">{{ $trx->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-slate-700">{{ $trx->details->sum('quantity') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-slate-900 font-semibold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada transaksi hari ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900">Stok Kritis</h3>
                            <p class="mt-1 text-sm text-slate-500">Produk yang perlu restock segera.</p>
                        </div>
                        <div class="divide-y divide-slate-200">
                            @forelse($criticalStockItems as $stock)
                                <div class="p-4 flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $stock->product->name }}</p>
                                        <p class="text-xs text-slate-500">SKU: {{ $stock->product->sku }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-red-600">{{ $stock->stock }}</p>
                                        <p class="text-xs text-slate-500">pcs tersisa</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-slate-500">Semua stok cabang aman.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
