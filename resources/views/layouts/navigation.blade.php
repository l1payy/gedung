<nav x-data="{ open: false }" class="bg-[#15803D] text-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left: Logo & Name -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 whitespace-nowrap">
                    <img src="{{ asset('storage/img/logo-navbar.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                    <span class="font-semibold text-white">Gedung Serba Guna Aulia</span>
                </a>
            </div>

            <!-- Middle: Desktop Menu -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}"
                    class="text-sm {{ request()->routeIs('home') ? 'font-semibold underline underline-offset-4' : 'hover:underline' }}">Home</a>
                <a href="{{ route('home') }}#kalender" class="text-sm hover:underline">Pesan Gedung</a>
                @auth
                    <a href="{{ route('bookings.index') }}"
                        class="text-sm {{ request()->routeIs('bookings.index') ? 'font-semibold underline underline-offset-4' : 'hover:underline' }}">Pemesanan
                        Saya</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.bookings.index') }}"
                            class="text-sm {{ request()->routeIs('admin.bookings.index') ? 'font-semibold underline underline-offset-4' : 'hover:underline' }}">Daftar Pemesanan</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-sm hover:underline">Pemesanan Saya</a>
                @endauth
                <a href="{{ route('home') }}#kontak" class="text-sm hover:underline">Kontak</a>
            </div>

            <!-- Right: Settings Dropdown & Hamburger -->
            <div class="flex items-center gap-4">
                <!-- Settings Dropdown (Desktop) -->
                <div class="hidden sm:flex sm:items-center">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-1 rounded bg-white text-[#15803D] hover:bg-gray-100 font-bold">Masuk</a>
                    @endauth
                </div>

                <!-- Hamburger (Mobile) -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#15803D] text-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('home') . '#kalender'">Pesan Gedung</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bookings.index')">Pemesanan Saya</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('home') . '#kontak'">Kontak</x-responsive-nav-link>
            @auth
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.index')">Daftar Pemesanan</x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @auth
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @else
                    <div class="font-medium text-base text-gray-800">Tamu</div>
                    <div class="font-medium text-sm text-gray-500">—</div>
                @endauth
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @auth
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('login')">Masuk</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">Daftar</x-responsive-nav-link>
                @endauth
            </div>
        </div>
    </div>
</nav>
