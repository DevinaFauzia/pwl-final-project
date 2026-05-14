<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Dashboard Owner

        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <x-dashboard-card
                    title="Total Cabang"
                    link="{{ route('owner.branches.index') }}">

                    {{ $totalBranches }}

                </x-dashboard-card>

                <x-dashboard-card
                    title="Total User"
                    link="#">

                    {{ $totalUsers }}

                </x-dashboard-card>

            </div>

        </div>

    </div>

</x-app-layout><x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Dashboard Owner

        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <x-dashboard-card
                    title="Total Cabang"
                    link="{{ route('owner.branches.index') }}">

                    {{ $totalBranches }}

                </x-dashboard-card>

                <x-dashboard-card
                    title="Total User"
                    link="#">

                    {{ $totalUsers }}

                </x-dashboard-card>

            </div>

        </div>

    </div>

</x-app-layout>