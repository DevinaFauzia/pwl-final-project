<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Cabang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="mb-4 flex justify-end">
                    <a href="{{ route('owner.branches.create') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Tambah Cabang
                    </a>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Nama Cabang</th>
                            <th class="p-3 border">Kota</th>
                            <th class="p-3 border">Alamat</th>
                            <th class="p-3 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($branches as $branch)
                        <tr>
                            <td class="p-3 border">{{ $loop->iteration }}</td>
                            <td class="p-3 border">{{ $branch->name }}</td>
                            <td class="p-3 border">{{ $branch->city }}</td>
                            <td class="p-3 border">{{ $branch->address }}</td>

                            <td class="p-3 border">
                                <div class="flex gap-2">

                                    <a href="{{ route('owner.branches.edit', $branch->id) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('owner.branches.destroy', $branch->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus cabang ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</x-app-layout>