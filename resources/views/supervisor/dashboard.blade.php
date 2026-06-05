<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Dashboard Supervisor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-dashboard-card link="{{ route('supervisor.transactions.index') }}" title="Pantau Transaksi Harian" subtitle="Awasi aktivitas kasir hari ini secara real-time" colorClass="bg-blue-600 text-white" borderClass="" >
                    <x-slot name="icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4"></path></svg>
                    </x-slot>
                </x-dashboard-card>
            </div>
        </div>
    </div>
</x-app-layout>
