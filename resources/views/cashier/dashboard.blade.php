<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Dashboard Kasir
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-dashboard-card link="{{ route('cashier.pos.create') }}" title="Point of Sales (POS)" subtitle="Mulai layani transaksi pembeli" colorClass="bg-indigo-600 text-white" borderClass="">
                    <x-slot name="icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6"></path></svg>
                    </x-slot>
                </x-dashboard-card>

                <x-dashboard-card link="{{ route('cashier.dashboard') ?? '#' }}" title="Transaksi Terkini" subtitle="Ringkasan transaksi shift Anda" colorClass="bg-white text-gray-900" borderClass="">
                    @if(session('error'))
                        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="grid gap-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Transaksi Hari Ini</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">{{ number_format($totalTransactions ?? 0) }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Omset Hari Ini</p>
                                <p class="mt-2 text-3xl font-bold text-green-600">Rp {{ number_format($dailyOmset ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Item Terjual</p>
                                <p class="mt-2 text-3xl font-bold text-indigo-600">{{ number_format($itemsSold ?? 0) }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Stok Kritis</p>
                                <p class="mt-2 text-3xl font-bold text-rose-600">{{ number_format($lowStockCount ?? 0) }}</p>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-800">Transaksi Terbaru</h3>
                            <div class="mt-3 space-y-3">
                                @forelse($recentTransactions ?? collect() as $trx)
                                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-3">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{{ $trx->user->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $trx->created_at->format('H:i:s, d M Y') }}</p>
                                        </div>
                                        <p class="text-sm font-bold text-slate-900">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-500 italic">Belum ada transaksi hari ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </x-dashboard-card>
            </div>
        </div>
    </div>
</x-app-layout>
