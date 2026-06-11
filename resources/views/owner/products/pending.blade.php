<x-app-layout>
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Persetujuan Produk</h2>
            <p class="text-sm text-gray-500 mt-1">Review dan setujui produk baru yang ditambahkan oleh manager.</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('owner.products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Produk
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="ml-3 w-full">
            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
        </div>
        <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
                <button type="button" class="inline-flex rounded-md bg-emerald-50 p-1.5 text-emerald-500 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 focus:ring-offset-emerald-50" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($products as $product)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm-.5-6a.5.5 0 11-1 0 .5.5 0 011 0zm2-2a.5.5 0 11-1 0 .5.5 0 011 0z" clip-rule="evenodd"></path></svg>
                                Menunggu Persetujuan
                            </span>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">
                            <p><strong>SKU:</strong> {{ $product->sku }}</p>
                            <p><strong>Kategori:</strong> {{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                            <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->description)
                            <p><strong>Deskripsi:</strong> {{ $product->description }}</p>
                            @endif
                        </div>
                        <div class="mt-3 text-xs text-gray-500">
                            Ditambahkan pada {{ $product->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <form action="{{ route('owner.products.reject', $product) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center text-rose-600 bg-rose-50 hover:bg-rose-100 px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>
                    </form>
                    <form action="{{ route('owner.products.approve', $product) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Setujui
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk menunggu persetujuan</h3>
                <p class="mt-1 text-sm text-gray-500">Semua produk sudah diproses atau belum ada yang perlu ditinjau.</p>
                <div class="mt-6">
                    <a href="{{ route('owner.products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</x-app-layout>
