<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-shrink-0">
    <div class="h-16 flex items-center px-6 border-b border-slate-800">
        <div class="font-bold text-xl text-white">Jayusman Market</div>
    </div>
    
    <div class="px-6 py-4">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Enterprise Admin</div>
        <a href="#" class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg text-center transition-colors mb-6">
            + Add New Branch
        </a>
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span class="font-medium">Dashboard</span>
        </a>
        
        @if(Auth::check() && Auth::user()->role === 'owner')
        <a href="{{ route('owner.products.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.products.*') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.products.*') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <span class="font-medium">Inventory</span>
        </a>
        <a href="{{ route('owner.reports.transactions') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.reports.transactions') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.reports.transactions') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            <span class="font-medium">Transactions</span>
        </a>
        <a href="{{ route('owner.reports.stocks') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg {{ request()->routeIs('owner.reports.stocks') ? 'bg-slate-800 text-white border-l-4 border-emerald-500' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <svg class="w-5 h-5 {{ request()->routeIs('owner.reports.stocks') ? 'text-emerald-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="font-medium">Reports</span>
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
