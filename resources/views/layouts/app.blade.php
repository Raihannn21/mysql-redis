<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Heroicons -->
    <script src="https://unpkg.com/heroicons@2.0.16/dist/24/solid.js"></script>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-50 text-gray-800 min-h-screen flex">

    <!-- Mobile Sidebar Overlay -->
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-md transform md:translate-x-0 md:static md:inset-0 transition-transform duration-200 ease-in-out flex flex-col"
        :class="{ '-translate-x-full': !sidebarOpen }"
    >
        <!-- Brand / Header -->
        <div class="h-16 flex items-center justify-center bg-indigo-600 text-white text-xl font-bold flex-shrink-0">
            Kelompok 4
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto">
            <ul class="p-4 space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-indigo-100 {{ request()->routeIs('dashboard') ? 'bg-indigo-100 font-semibold' : '' }}">
                        <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 12l2-2 4 4 8-8 2 2v6H3z"></path></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-indigo-100 {{ request()->routeIs('products.*') ? 'bg-indigo-100 font-semibold' : '' }}">
                        <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"></path></svg>
                        Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('cart.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-indigo-100 {{ request()->routeIs('cart.index') ? 'bg-indigo-100 font-semibold' : '' }}">
                        <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        Keranjang
                    </a>
                </li>
                <li>
                    <a href="{{ route('checkout.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-indigo-100 {{ request()->routeIs('checkout.index') ? 'bg-indigo-100 font-semibold' : '' }}">
                        <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 12v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Checkout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="p-4">
            @csrf
            <button type="submit" class="w-full px-4 py-2 text-left text-red-600 hover:text-red-800 hover:bg-red-100 rounded">
                Keluar
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Navbar (mobile toggle button + welcome) -->
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden focus:outline-none">
                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>
        </header>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-4xl mx-auto mt-6" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Page Content -->
        <main class="p-6 flex-1 overflow-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>
