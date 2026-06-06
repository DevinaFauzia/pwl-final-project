<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                Laporan Stok Barang
            </h2>
            <button onclick="window.print()"
                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">Cetak
                Laporan</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Jumlah Item Stok Cabang</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totalStocks, 0, ',', '.') }}</p>
            </div>
            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        SKU</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nama Produk</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($stocks as $stock)
                                    <tr class="hover:bg-indigo-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $stock->product->sku }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">
                                            {{ $stock->product->name }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $stock->stock < 10 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $stock->stock }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">Tidak ada data
                                            stok.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>