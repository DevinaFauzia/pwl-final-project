<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                Laporan Transaksi Cabang
            </h2>
            <button onclick="window.print()"
                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">Cetak
                Laporan</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid gap-4 mb-6 md:grid-cols-2">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Total Transaksi Cabang</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">
                        {{ number_format($totalTransactions, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Total Penjualan Cabang</p>
                    <p class="mt-2 text-3xl font-semibold text-green-600">Rp
                        {{ number_format($totalAmount, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 print:hidden">
                <form action="{{ route('manager.reports.transactions') }}" method="GET"
                    class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/3">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>
                    <div class="w-full md:w-auto">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition duration-200">Filter
                            Tanggal</button>
                    </div>
                </form>
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
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Kasir</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Detail Barang</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($transactions as $trx)
                                    <tr class="hover:bg-indigo-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $trx->user->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <ul class="list-disc list-inside">
                                                @foreach($trx->details as $detail)
                                                    <li>{{ $detail->product->name }} (x{{ $detail->quantity }})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                            Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Tidak ada data
                                            transaksi.</td>
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