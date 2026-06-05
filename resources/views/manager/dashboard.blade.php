<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Dashboard Manager
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-dashboard-card link="{{ route('manager.reports.transactions') }}" title="Laporan Transaksi" subtitle="Cetak riwayat transaksi cabang Anda" colorClass="bg-emerald-600 text-white" borderClass="">
                    <x-slot name="icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path></svg>
                    </x-slot>
                </x-dashboard-card>

                <x-dashboard-card link="{{ route('manager.reports.stocks') }}" title="Laporan Stok Barang" subtitle="Cetak sisa stok cabang Anda" colorClass="bg-indigo-600 text-white" borderClass="">
                    <x-slot name="icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7"></path></svg>
                    </x-slot>
                </x-dashboard-card>
            </div>
        </div>
    </div>
</x-app-layout>
