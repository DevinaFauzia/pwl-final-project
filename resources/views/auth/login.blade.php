<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-slate-900">Masuk ke Jaymart</h1>
        <p class="mt-2 text-sm text-slate-500">Akses sistem manajemen cabang untuk Owner, Manager, Supervisor, Kasir, dan Gudang.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email Akun" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-800 font-medium" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto">
                Masuk
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-sm text-slate-500">
        <p>Gunakan akun resmi perusahaan untuk login. Pastikan Anda memilih akun sesuai peran Anda.</p>
    </div>
</x-guest-layout>
