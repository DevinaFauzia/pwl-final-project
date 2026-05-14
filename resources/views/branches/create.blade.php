<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Tambah Cabang

        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('owner.branches.store') }}"
                      method="POST">

                    @csrf

                    <div class="mb-4">

                        <label class="block mb-2">
                            Nama Cabang
                        </label>

                        <input type="text"
                               name="name"
                               class="w-full border rounded p-2">

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2">
                            Kota
                        </label>

                        <input type="text"
                               name="city"
                               class="w-full border rounded p-2">

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2">
                            Alamat
                        </label>

                        <textarea name="address"
                                  class="w-full border rounded p-2"></textarea>

                    </div>

                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">

                        Simpan

                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>