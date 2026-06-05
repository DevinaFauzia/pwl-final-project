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
                    <!-- content slot left empty for dynamic content -->
                </x-dashboard-card>
            </div>
        </div>
    </div>
</x-app-layout>
