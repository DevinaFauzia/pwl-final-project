<x-app-layout>
    <div class="mb-8">
        <a href="{{ route('manager.products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Produk
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Edit Produk: {{ $product->name }}</h2>
        <p class="text-sm text-gray-500 mt-1">Ubah informasi produk. Jika produk sudah disetujui, perubahan akan ditampilkan langsung.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden max-w-3xl">
        <form action="{{ route('manager.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 md:p-8 space-y-6">
                <!-- Validation Errors -->
                @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 rounded-lg p-4 flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="ml-3 w-full">
                        <h3 class="text-sm font-bold text-rose-800">Terdapat kesalahan pada isian Anda:</h3>
                        <div class="mt-2 text-sm text-rose-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Status Badge -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-semibold text-gray-600">Status:</span>
                    @if($product->status == 'pending')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm-.5-6a.5.5 0 11-1 0 .5.5 0 011 0zm2-2a.5.5 0 11-1 0 .5.5 0 011 0z" clip-rule="evenodd"></path></svg>
                            Menunggu Persetujuan
                        </span>
                    @elseif($product->status == 'approved')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Disetujui
                        </span>
                    @elseif($product->status == 'rejected')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            Ditolak
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sku" class="block text-sm font-bold text-gray-700 mb-1">SKU (Stock Keeping Unit)</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" required>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-1">Harga Jual (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" min="0" required>
                    </div>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-1">Kategori Produk</label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" required>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                <a href="{{ route('manager.products.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
