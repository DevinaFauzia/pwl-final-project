<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pengguna Cabang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6 flex justify-end">
                    <a href="{{ route('owner.users.create') }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        + Tambah Pengguna Baru
                    </a>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Nama</th>
                            <th class="p-3 border">Email</th>
                            <th class="p-3 border">Role</th>
                            <th class="p-3 border">Cabang</th>
                            <th class="p-3 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="p-3 border">{{ $loop->iteration }}</td>
                                <td class="p-3 border">{{ $user->name }}</td>
                                <td class="p-3 border text-sm">{{ $user->email }}</td>
                                <td class="p-3 border">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        @if($user->role === 'manager') bg-blue-100 text-blue-800
                                        @elseif($user->role === 'warehouse') bg-purple-100 text-purple-800
                                        @elseif($user->role === 'cashier') bg-indigo-100 text-indigo-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="p-3 border">
                                    @if($user->branch)
                                        <span class="text-sm font-medium">{{ $user->branch->name }}</span><br>
                                        <span class="text-xs text-slate-500">{{ $user->branch->city }}</span>
                                    @else
                                        <span class="text-red-600 font-medium">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td class="p-3 border">
                                    <div class="flex gap-2">
                                        <a href="{{ route('owner.users.edit', $user->id) }}"
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                           Edit
                                        </a>
                                        <form action="{{ route('owner.users.destroy', $user->id) }}"
                                              method="POST"
                                              style="display: inline;"
                                              onsubmit="return confirm('Yakin hapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-500">Tidak ada pengguna yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
