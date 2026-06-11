<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">Dashboard Owner</h2>
                <p class="text-sm text-gray-500 mt-1">Ringkasan kinerja cabang, produk, dan staf di seluruh jaringan.</p>
            </div>
            <div class="rounded-2xl bg-slate-50 px-4 py-3 border border-slate-200 text-sm text-slate-700">
                <span class="font-semibold">{{ today()->format('d M Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Cabang Terdaftar</p>
                    <p class="mt-4 text-3xl font-bold text-slate-900">{{ $branchesCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Jumlah cabang aktif dalam sistem.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Produk Terdaftar</p>
                    <p class="mt-4 text-3xl font-bold text-slate-900">{{ $productCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total SKU yang tersedia di semua cabang.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Pengguna Terdaftar</p>
                    <p class="mt-4 text-3xl font-bold text-slate-900">{{ $userCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Jumlah akun karyawan dan admin yang terdaftar.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Transaksi Hari Ini</p>
                    <p class="mt-4 text-3xl font-bold text-slate-900">{{ $totalTransactions }}</p>
                    <p class="mt-2 text-sm text-slate-500">Transaksi dari seluruh cabang hari ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Omset Hari Ini</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">Rp {{ number_format($dailyOmset, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-2xl bg-emerald-50 px-3 py-2 text-emerald-700 text-xs font-semibold">Terbaru</div>
                    </div>
                    <p class="mt-4 text-sm text-slate-500">Total pemasukan dari semua cabang hari ini.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Stok Kritis</p>
                            <p class="mt-4 text-3xl font-bold text-red-600">{{ $criticalStocksCount }}</p>
                        </div>
                        <div class="rounded-2xl bg-red-50 px-3 py-2 text-red-700 text-xs font-semibold">Waspada</div>
                    </div>
                    <p class="mt-4 text-sm text-slate-500">Produk yang perlu restock segera.</p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Transaksi Terbaru</h3>
                        <p class="mt-1 text-sm text-slate-500">Lima transaksi paling baru dari semua cabang.</p>
                    </div>
                    <a href="{{ route('owner.reports.transactions') }}" class="text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-full px-3 py-2 hover:bg-slate-50 transition">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-100 text-slate-600 uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="px-6 py-3 text-left">Tanggal</th>
                                <th class="px-6 py-3 text-left">Cabang</th>
                                <th class="px-6 py-3 text-center">Items</th>
                                <th class="px-6 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($recentTransactions as $trx)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-900 font-semibold">{{ $trx->branch->name ?? 'Tanpa Cabang' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-slate-700">{{ $trx->details->sum('quantity') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-slate-900 font-semibold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada transaksi terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
