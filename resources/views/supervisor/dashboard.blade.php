<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Dashboard Supervisor - Pantau Aktivitas Penjualan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($message = session('error'))
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                    {{ $message }}
                </div>
            @endif

            <!-- Statistik Utama -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Transaksi -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Total Transaksi</p>
                            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalTransactions }}</p>
                            <p class="text-xs text-slate-500 mt-1">Transaksi hari ini</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
                        </svg>
                    </div>
                </div>

                <!-- Total Omset -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Total Omset</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($dailyOmset, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500 mt-1">Pendapatan hari ini</p>
                        </div>
                        <svg class="w-12 h-12 text-green-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Total Item Terjual -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Total Item Terjual</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalItems }}</p>
                            <p class="text-xs text-slate-500 mt-1">Jumlah produk</p>
                        </div>
                        <svg class="w-12 h-12 text-purple-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>

                <!-- Kasir Aktif -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Kasir Aktif</p>
                            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $cashiersActive->count() }}</p>
                            <p class="text-xs text-slate-500 mt-1">Sedang melayani</p>
                        </div>
                        <svg class="w-12 h-12 text-indigo-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10h2v2h-2v-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Produk Terlaris -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-white font-bold text-lg">Produk Terlaris Hari Ini</h3>
                    </div>
                    <div class="p-6">
                        @if($topProducts->count() > 0)
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-2 text-slate-600 font-semibold">Produk</th>
                                        <th class="text-right py-2 text-slate-600 font-semibold">Qty</th>
                                        <th class="text-right py-2 text-slate-600 font-semibold">Penjualan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProducts as $item)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                                        <td class="py-3">
                                            <span class="font-medium text-slate-900">{{ $item->product->name }}</span>
                                        </td>
                                        <td class="text-right py-3">
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">
                                                {{ $item->total_qty }}
                                            </span>
                                        </td>
                                        <td class="text-right py-3 font-bold text-green-600">
                                            Rp {{ number_format($item->total_sales, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-slate-500 py-6">Belum ada penjualan hari ini</p>
                        @endif
                    </div>
                </div>

                <!-- Performa Kasir -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-white font-bold text-lg">Performa Kasir Hari Ini</h3>
                    </div>
                    <div class="p-6">
                        @if($cashiersActive->count() > 0)
                            <div class="space-y-4">
                                @foreach($cashiersActive as $cashierData)
                                <div class="border border-slate-200 rounded-lg p-4 hover:bg-slate-50">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $cashierData['cashier']->name }}</p>
                                            <p class="text-xs text-slate-500">Kasir</p>
                                        </div>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">
                                            {{ $cashierData['count'] }} transaksi
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-xs text-slate-600 mb-1">Total Omset:</p>
                                        <p class="text-lg font-bold text-green-600">
                                            Rp {{ number_format($cashierData['total'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-slate-500 py-6">Belum ada kasir aktif</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-white font-bold text-lg">Transaksi Terbaru</h3>
                    <a href="{{ route('supervisor.transactions.index') }}" class="text-white hover:text-indigo-100 text-sm font-medium transition-colors">
                        Lihat Semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Waktu</th>
                                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Kasir</th>
                                <th class="text-left px-6 py-3 text-slate-600 font-semibold">Items</th>
                                <th class="text-right px-6 py-3 text-slate-600 font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <span class="font-medium text-slate-900">
                                        {{ $transaction->created_at->format('H:i:s') }}
                                    </span>
                                    <br>
                                    <span class="text-xs text-slate-500">
                                        {{ $transaction->created_at->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-900">{{ $transaction->user->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-slate-100 text-slate-800 px-3 py-1 rounded text-xs font-semibold">
                                        {{ $transaction->details->count() }} item
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="font-bold text-green-600">
                                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </p>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada transaksi hari ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
