<x-app-layout>
    <div class="mb-8">
        <a href="{{ route('owner.categories.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Kategori
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Tambah Kategori Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Buat kategori produk agar kasir dan gudang dapat menyaring produk secara lebih mudah.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden max-w-3xl">
        <form action="{{ route('owner.categories.store') }}" method="POST">
            @csrf
            <div class="p-6 md:p-8 space-y-6">
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

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm" placeholder="Contoh: Minuman, Daging, Snack" required>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                <a href="{{ route('owner.categories.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">Simpan Kategori</button>
            </div>
        </form>
    </div>
</x-app-layout>
