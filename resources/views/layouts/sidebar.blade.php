<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-shrink-0">
    <div class="h-16 flex items-center px-6 border-b border-slate-800">
        <div class="font-bold text-xl text-white">Jayusman Market</div>
    </div>
    
    <div class="px-6 py-4">
        @if(Auth::check() && Auth::user()->role === 'owner')
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Admin Perusahaan</div>
            <a href="{{ route('owner.users.create') }}" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors mb-3">
                + Tambah Staf
            </a>
            <a href="{{ route('owner.branches.create') }}" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors mb-6">
                + Tambah Cabang
            </a>
        @elseif(Auth::check() && Auth::user()->role === 'manager')
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Panel Manajer</div>
            <!-- <a href="{{ route('manager.reports.transactions') }}" class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors mb-6">
                Lihat Laporan Transaksi
            </a> -->
        @elseif(Auth::check() && Auth::user()->role === 'supervisor')
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Panel Pengawas</div>
            <!-- <a href="{{ route('supervisor.dashboard') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors mb-6">
                Dasbor & Analitik
            </a> -->
        @elseif(Auth::check() && Auth::user()->role === 'cashier')
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kasir Panel</div>
            <!-- <a href="{{ route('cashier.pos.create') }}" class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors mb-6">
                Buka POS
            </a> -->
        @elseif(Auth::check() && Auth::user()->role === 'warehouse')
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Panel Gudang</div>
            <!-- <a href="{{ route('warehouse.stock.index') }}" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors mb-6">
                Riwayat Stok
            </a> -->
        @else
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Akses Cepat</div>
        @endif
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        @if(Auth::check() && Auth::user()->role === 'owner')
        <div class="mt-4 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pemilik</div>
        <a href="{{ route('owner.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.dashboard') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.dashboard') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2-2l6-6m0 0l6 6m-6-6v18m0 0l-6-6m6 6l6-6"></path></svg>
            <span class="font-medium">Dasbor</span>
        </a>
        <a href="{{ route('owner.branches.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.branches.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.branches.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path></svg>
            <span class="font-medium">Cabang</span>
        </a>
        <a href="{{ route('owner.categories.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.categories.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.categories.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            <span class="font-medium">Kategori</span>
        </a>
        <a href="{{ route('owner.products.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.products.*') && !request()->routeIs('owner.products.pending') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.products.*') && !request()->routeIs('owner.products.pending') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <span class="font-medium">Produk</span>
        </a>
        <a href="{{ route('owner.products.pending') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.products.pending') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.products.pending') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">Persetujuan Produk</span>
        </a>
        <a href="{{ route('owner.users.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.users.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.users.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="font-medium">Staff Cabang</span>
        </a>
        <a href="{{ route('owner.reports.transactions') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.reports.transactions') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.reports.transactions') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path></svg>
            <span class="font-medium">Laporan Transaksi</span>
        </a>
        <a href="{{ route('owner.reports.stocks') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.reports.stocks') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.reports.stocks') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="font-medium">Laporan Stok</span>
        </a>
        @endif

        @if(Auth::check() && Auth::user()->role === 'manager')
        <div class="mt-4 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Manajer</div>
        <a href="{{ route('manager.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('manager.dashboard') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('manager.dashboard') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2-2l6-6m0 0l6 6m-6-6v18m0 0l-6-6m6 6l6-6"></path></svg>
            <span class="font-medium">Dasbor</span>
        </a>
        <a href="{{ route('manager.products.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('manager.products.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('manager.products.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <span class="font-medium">Manajemen Produk</span>
        </a>
        <a href="{{ route('manager.reports.transactions') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('manager.reports.transactions') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('manager.reports.transactions') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path></svg>
            <span class="font-medium">Laporan Transaksi</span>
        </a>
        <a href="{{ route('manager.reports.stocks') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('manager.reports.stocks') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('manager.reports.stocks') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span class="font-medium">Laporan Stok</span>
        </a>
        @endif

        @if(Auth::check() && Auth::user()->role === 'supervisor')
        <div class="mt-4 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Supervisor</div>
        <a href="{{ route('supervisor.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('supervisor.dashboard') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('supervisor.dashboard') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2-2l6-6m0 0l6 6m-6-6v18m0 0l-6-6m6 6l6-6"></path></svg>
            <span class="font-medium">Dasbor</span>
        </a>
        <a href="{{ route('supervisor.transactions.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('supervisor.transactions.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('supervisor.transactions.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">Transaksi Hari Ini</span>
        </a>
        @endif

        @if(Auth::check() && Auth::user()->role === 'cashier')
        <div class="mt-4 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Panel Kasir</div>
        <a href="{{ route('cashier.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('cashier.dashboard') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('cashier.dashboard') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2-2l6-6m0 0l6 6m-6-6v18m0 0l-6-6m6 6l6-6"></path></svg>
            <span class="font-medium">Dasbor</span>
        </a>
        <a href="{{ route('cashier.pos.create') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('cashier.pos.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('cashier.pos.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 8m10 0l2-8m-10 8h10m0 0l2 8h-2m0 0H9"></path></svg>
            <span class="font-medium">Kasir/POS</span>
        </a>
        @endif

        @if(Auth::check() && Auth::user()->role === 'warehouse')
        <div class="mt-4 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Gudang</div>
        <a href="{{ route('warehouse.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('warehouse.dashboard') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('warehouse.dashboard') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2-2l6-6m0 0l6 6m-6-6v18m0 0l-6-6m6 6l6-6"></path></svg>
            <span class="font-medium">Dasbor</span>
        </a>
        <a href="{{ route('warehouse.stock.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('warehouse.stock.index') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('warehouse.stock.index') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">Riwayat Stok</span>
        </a>
        <a href="{{ route('warehouse.inventory.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('warehouse.inventory.index') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('warehouse.inventory.index') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="font-medium">Daftar Stok</span>
        </a>
        <a href="{{ route('warehouse.stock.opname.create') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('warehouse.stock.opname.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('warehouse.stock.opname.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            <span class="font-medium">Opname Stok</span>
        </a>
        <a href="{{ route('warehouse.stock.transfer.create') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('warehouse.stock.transfer.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('warehouse.stock.transfer.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
            <span class="font-medium">Transfer Stok</span>
        </a>
        <a href="{{ route('warehouse.stock.create') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('warehouse.stock.create') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('warehouse.stock.create') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span class="font-medium">Tambah Stok</span>
        </a>
        @endif
        
        <!-- Tautan navigasi untuk role lain (Manager, Supervisor, dsb) dapat ditambahkan di sini nantinya -->
    </nav>
    
    <div class="p-4 border-t border-slate-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center space-x-3 w-full px-3 py-2 rounded-lg hover:bg-slate-800 hover:text-white transition-colors text-left">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&color=7F9CF5&background=EBF4FF" alt="Avatar" class="w-8 h-8 rounded-full border border-slate-700">
                <div class="overflow-hidden">
                    <div class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="text-xs text-slate-500 truncate capitalize">{{ Auth::user()->role ?? 'Guest' }}</div>
                </div>
            </button>
        </form>
    </div>
</aside>
