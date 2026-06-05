<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Dashboard Gudang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-dashboard-card link="{{ route('warehouse.stock.index') }}" title="Riwayat Pergerakan Stok" subtitle="Lihat log barang masuk dan keluar" colorClass="bg-indigo-600 text-white" borderClass="">
                    <x-slot name="icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7"></path></svg>
                    </x-slot>
                </x-dashboard-card>
                <x-dashboard-card link="{{ route('warehouse.stock.create') }}" title="Input Pergerakan Stok" subtitle="Catat penambahan atau pengurangan barang fisik" colorClass="bg-emerald-600 text-white" borderClass="">
                    <x-slot name="icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8"></path></svg>
                    </x-slot>
                </x-dashboard-card>
            </div>
        </div>
    </div>
</x-app-layout>
