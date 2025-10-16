<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username Address -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Autofill User Account Card -->
    <div class="mt-6 p-4 bg-gray-100 rounded-md shadow-sm">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">USER ACCOUNT</h2>
        <p class="text-sm text-gray-600 mb-3">Klik tombol dibawah ini untuk menggunakan akun USER</p>

        <x-primary-button id="fill-demo-account" type="button"
            class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
            Use User Account
        </x-primary-button>
    </div>

    <!-- Autofill Admin Account Card -->
    <div class="mt-6 p-4 bg-gray-100 rounded-md shadow-sm">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">ADMIN ACCOUNT</h2>
        <p class="text-sm text-gray-600 mb-3">Klik tombol dibawah ini untuk menggunakan akun ADMIN</p>

        <x-primary-button id="fill-admin-account" type="button"
            class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
            Use Admin Account
        </x-primary-button>
    </div>

    <!-- Autofill Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const demoUser = {
                username: 'user',
                password: 'password'
            };

            const adminUser = {
                username: 'irfan',
                password: 'irfan'
            };

            document.getElementById('fill-demo-account').addEventListener('click', function() {
                document.getElementById('username').value = demoUser.username;
                document.getElementById('password').value = demoUser.password;
            });

            document.getElementById('fill-admin-account').addEventListener('click', function() {
                document.getElementById('username').value = adminUser.username;
                document.getElementById('password').value = adminUser.password;
            });
        });
    </script>

</x-guest-layout>
