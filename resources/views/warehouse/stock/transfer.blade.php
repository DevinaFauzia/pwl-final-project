<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">Transfer Stok Antar Cabang</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('warehouse.stock.transfer.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Produk</label>
                            <select name="product_id" id="product_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->sku }} - {{ $product->name }} @if($product->category) ({{ $product->category->name }}) @endif</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="destination_branch_id" class="block text-sm font-medium text-gray-700 mb-2">Cabang Tujuan</label>
                            <select name="destination_branch_id" id="destination_branch_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                <option value="">-- Pilih Cabang --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('destination_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }} - {{ $branch->city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Transfer</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required min="1">
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Transfer</label>
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-8">
                            <a href="{{ route('warehouse.inventory.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition-colors">Batal</a>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:-translate-y-1">Simpan Transfer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
