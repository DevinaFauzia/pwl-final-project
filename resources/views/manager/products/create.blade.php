<x-app-layout>
    <div class="mb-8">
        <a href="{{ route('manager.products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Produk
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Masukkan informasi produk. Produk baru akan menunggu persetujuan owner sebelum bisa digunakan.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden max-w-3xl">
        <form action="{{ route('manager.products.store') }}" method="POST">
            @csrf
            
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sku" class="block text-sm font-bold text-gray-700 mb-1">SKU (Stock Keeping Unit)</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" placeholder="Contoh: BRS-001" required>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-1">Harga Jual (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" placeholder="Contoh: 15000" min="0" required>
                    </div>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-1">Kategori Produk</label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" placeholder="Masukkan nama lengkap produk..." required>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" placeholder="Tambahkan keterangan produk jika ada...">{{ old('description') }}</textarea>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-amber-800">Perhatian</h3>
                        <div class="mt-1 text-sm text-amber-700">Produk yang Anda tambahkan akan masuk ke status <strong>"Menunggu Persetujuan"</strong> dan baru bisa digunakan setelah owner menyetujuinya.</div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                <a href="{{ route('manager.products.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
