<header class="bg-white shadow-md z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="">
            <h1 class="text-3xl font-extrabold text-green-600 hover:text-green-700">GETVACC</h1>
        </a>

        <button id="menu-toggle" class="lg:hidden focus:outline-none" onclick="toggleMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Navbar for desktop -->
        <nav class="hidden lg:flex space-x-6 items-center">
            <a href="{{ route('home') }}"
                class="text-gray-700 font-medium hover:text-green-600 ease-in-out duration-300 {{ request()->routeIs('home') ? 'text-green-600' : '' }}">Home</a>
            <a href="{{ route('search.view') }}"
                class="text-gray-700 font-medium hover:text-green-600 ease-in-out duration-300 {{ request()->routeIs('search.view') ? 'text-green-600' : '' }}">Check
                Status</a>
        </nav>
    </div>

    <!-- Mobile menu -->
    <nav id="mobile-menu" class="hidden lg:hidden bg-white">
        <div class="px-6 py-4 space-y-4">
            <a href="{{ route('home') }}"
                class="block text-gray-700 font-medium hover:bg-gray-100 py-2 px-3 px-3 rounded-lg {{ request()->routeIs('home') ? 'bg-gray-100' : '' }}">Home</a>
            <a href="{{ route('search.view') }}"
                class="block text-gray-700 font-medium hover:bg-gray-100 p-2 rounded-lg {{ request()->routeIs('search.view') ? 'bg-gray-100' : '' }}">Check
                Status</a>
        </div>
    </nav>
</header>
