<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMS QC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/kmslogo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('styles')
</head>

<body class="bg-gray-100">
    {{-- Menambahkan kelas 'sticky', 'top-0', dan 'z-50' untuk membuat navbar mengikuti scroll --}}
    {{-- <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-xl font-bold text-gray-800">
                    <img src="{{ asset('images/kmslogo.png') }}" alt="Logo" class="h-16 w-16">
                    <span>Keeping Sample Management System</span>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 text-gray-700 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('stocks.index') }}" class="px-3 py-2 text-gray-700 hover:text-gray-900">Manajemen Stok</a>
                    <a href="{{ route('defective-reports.index') }}" class="px-3 py-2 text-gray-700 hover:text-gray-900">Laporan Deviasi</a>
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <span class="text-gray-600 mr-2">Welcome, {{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 hover:text-red-700">
                                Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav> --}}

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-xl font-bold text-gray-800">
                <img src="{{ asset('images/kmslogo.png') }}" alt="Logo" class="h-16 w-16" />
                <span>Keeping Sample Management System</span>
            </a>

            <!-- Hidden checkbox toggle -->
            <input type="checkbox" id="menu-toggle" class="hidden" />
            <!-- Hamburger menu button -->
            <label for="menu-toggle" class="sm:hidden cursor-pointer block">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </label>

            <!-- Navigation links -->
            <div id="menu" class="hidden sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('dashboard') }}"
                    class="block px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-300">Dashboard</a>
                <a href="{{ route('scan.page') }}"
                    class="block px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-300">Scan
                    Sample</a>
                <a href="{{ route('stocks.index') }}"
                    class="block px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-300">Manajemen
                    Stok</a>
                <a href="{{ route('defective-reports.index') }}"
                    class="block px-3 py-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-300">Laporan
                    Deviasi</a>
                <div class="sm:flex sm:items-center sm:ms-6">
                    <span class="text-gray-600 mr-2 block px-3 py-2">Welcome, {{ Auth::user()->name }}
                        ({{ Auth::user()->role }})</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-500 hover:text-red-700 block px-3 py-2">
                            Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <style>
        /* Show menu when checkbox is checked */
        #menu-toggle:checked+label+#menu {
            display: flex;
            flex-direction: column;
        }
    </style>


    {{-- burger button --}}
    {{-- <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-xl font-bold text-gray-800">
                <img src="{{ asset('images/kmslogo.png') }}" alt="Logo" class="h-16 w-16">
                <span>Keeping Sample Management System</span>
            </a>

            <!-- Burger button visible on small screens only -->
            <button id="burger-btn" class="sm:hidden flex flex-col space-y-1.5 cursor-pointer">
                <span class="block w-6 h-0.5 bg-gray-700"></span>
                <span class="block w-6 h-0.5 bg-gray-700"></span>
                <span class="block w-6 h-0.5 bg-gray-700"></span>
            </button>

            <!-- Navigation links -->
            <div id="nav-links" class="hidden sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 text-gray-700 hover:text-gray-900">Dashboard</a>
                <a href="{{ route('stocks.index') }}" class="px-3 py-2 text-gray-700 hover:text-gray-900">Manajemen Stok</a>
                <a href="{{ route('defective-reports.index') }}" class="px-3 py-2 text-gray-700 hover:text-gray-900">Laporan Deviasi</a>
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                <span class="text-gray-600 mr-2">Welcome, {{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 hover:text-red-700">
                    Logout
                    </a>
                </form>
                </div>
            </div>
            </div>

            <!-- Mobile menu (hidden by default) -->
            <div id="mobile-menu" class="sm:hidden hidden flex-col space-y-2 mt-3">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-700 hover:text-gray-900">Dashboard</a>
            <a href="{{ route('stocks.index') }}" class="block px-3 py-2 text-gray-700 hover:text-gray-900">Manajemen Stok</a>
            <a href="{{ route('defective-reports.index') }}" class="block px-3 py-2 text-gray-700 hover:text-gray-900">Laporan Deviasi</a>
            <div class="border-t border-gray-200 pt-2">
                <span class="block px-3 py-2 text-gray-600">Welcome, {{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 hover:text-red-700 block">
                    Logout
                </a>
                </form>
            </div>
            </div>
        </div>

        <script>
            // Toggle mobile menu visibility
            const burgerBtn = document.getElementById('burger-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            burgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            });
        </script>
        </nav> --}}

    <main class="container mx-auto px-6 py-8">
        {{-- Menampilkan pesan error jika ada --}}
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Akses Ditolak!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @yield('content')
    </main>
    @yield('scripts')
</body>

</html>
