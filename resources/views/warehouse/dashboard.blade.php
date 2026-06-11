<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">Dashboard Gudang</h2>
                <p class="text-sm text-gray-500 mt-1">Ringkasan stok dan mutasi untuk cabang Anda.</p>
            </div>
            <div class="rounded-2xl bg-slate-50 px-4 py-3 border border-slate-200 text-sm text-slate-700">
                Cabang: <span class="font-semibold text-slate-900">{{ $branchName ?? 'Belum terhubung' }}</span>
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

            <div class="grid gap-6 lg:grid-cols-4 mb-8">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Total Stok Cabang</p>
                    <p class="mt-4 text-3xl font-bold text-slate-900">{{ number_format($totalStockItems ?? 0, 0, ',', '.') }}</p>
                    <p class="mt-2 text-sm text-slate-500">Jumlah seluruh unit stok di cabang ini.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Stok Kritis</p>
                    <p class="mt-4 text-3xl font-bold text-rose-600">{{ number_format($criticalStockCount ?? 0, 0, ',', '.') }}</p>
                    <p class="mt-2 text-sm text-slate-500">Produk dengan stok kurang dari 10.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Mutasi Hari Ini</p>
                    <p class="mt-4 text-3xl font-bold text-slate-900">{{ number_format($totalTodayMovements ?? 0, 0, ',', '.') }}</p>
                    <p class="mt-2 text-sm text-slate-500">Jumlah pencatatan masuk/keluar stok hari ini.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Masuk / Keluar</p>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between rounded-2xl bg-emerald-50 p-3">
                            <span class="text-sm text-emerald-700">Masuk</span>
                            <span class="font-bold text-emerald-900">{{ number_format($totalIn ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-rose-50 p-3">
                            <span class="text-sm text-rose-700">Keluar</span>
                            <span class="font-bold text-rose-900">{{ number_format($totalOut ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200 bg-slate-50">
                        <h3 class="text-lg font-semibold text-slate-900">Mutasi Terbaru</h3>
                        <p class="mt-1 text-sm text-slate-500">5 pencatatan mutasi terbaru di cabang Anda.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-100 text-slate-600 uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th class="px-6 py-3 text-left">Waktu</th>
                                    <th class="px-6 py-3 text-left">Produk</th>
                                    <th class="px-6 py-3 text-center">Tipe</th>
                                    <th class="px-6 py-3 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse($recentMovements as $movement)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4 text-slate-700 whitespace-nowrap">{{ \Carbon\Carbon::parse($movement->date)->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 text-slate-900 font-semibold">{{ $movement->product->name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $movement->type === 'in' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ strtoupper($movement->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-slate-900 font-semibold">{{ $movement->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada catatan mutasi hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200 bg-slate-50">
                        <h3 class="text-lg font-semibold text-slate-900">Produk Stok Kritis</h3>
                        <p class="mt-1 text-sm text-slate-500">Produk dengan stok tersisa kurang dari 10.</p>
                    </div>
                    <div class="divide-y divide-slate-200">
                        @forelse($criticalProducts as $stock)
                            <div class="flex items-center justify-between px-6 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $stock->product->name ?? 'Produk tidak ditemukan' }}</p>
                                    <p class="text-xs text-slate-500">SKU: {{ $stock->product->sku ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-rose-600">{{ $stock->stock }}</p>
                                    <p class="text-xs text-slate-500">pcs</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-slate-500">Tidak ada stok kritis saat ini.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-8 rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
                <div class="flex items-center justify-between mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Aksi Cepat Gudang</h3>
                        <p class="mt-1 text-sm text-slate-500">Gunakan tombol ini untuk menambah stok atau menyesuaikan stok fisik.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('warehouse.stock.create') }}" class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">Tambah Stok</a>
                        <a href="{{ route('warehouse.stock.opname.create') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">Stock Opname</a>
                        <a href="{{ route('warehouse.stock.transfer.create') }}" class="inline-flex items-center justify-center rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-200 transition">Transfer Stok</a>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Tambah stok</p>
                        <p class="mt-2 text-sm text-slate-700">Catat barang masuk / keluar dengan cepat.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Stock opname</p>
                        <p class="mt-2 text-sm text-slate-700">Sesuaikan stok sistem dengan stok fisik.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Transfer</p>
                        <p class="mt-2 text-sm text-slate-700">Pindahkan stok antar cabang.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
