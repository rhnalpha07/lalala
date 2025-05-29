<!-- Responsive Navigation -->
<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-black/70 backdrop-blur-md border-b border-white/10 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-500">
                        SOUNDWAVE FEST
                    </a>
                </div>
            </div>

            <!-- Navigation Links (Desktop) -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                <a href="/#lineup" class="text-white/80 hover:text-white hover:border-b-2 hover:border-pink-500 px-1 py-4 text-sm font-medium transition-all duration-200">
                    Artists
                </a>
                <a href="/#events" class="text-white/80 hover:text-white hover:border-b-2 hover:border-pink-500 px-1 py-4 text-sm font-medium transition-all duration-200">
                    Events
                </a>
                <a href="/#tickets" class="text-white/80 hover:text-white hover:border-b-2 hover:border-pink-500 px-1 py-4 text-sm font-medium transition-all duration-200">
                    Tickets
                </a>
                <a href="/#faq" class="text-white/80 hover:text-white hover:border-b-2 hover:border-pink-500 px-1 py-4 text-sm font-medium transition-all duration-200">
                    FAQ
                </a>
            </div>

            <!-- Right Side Menu -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Theme Toggle -->
                <button x-on:click="theme = theme === 'dark' ? 'light' : 'dark'" class="text-white/80 hover:text-white focus:outline-none p-2 rounded-full bg-white/10 hover:bg-white/20 transition-all duration-200">
                    <template x-if="theme==='dark'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </template>
                    <template x-if="theme==='light'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </template>
                </button>

                <!-- Authentication Links -->
                @guest
                    <a href="{{ route('login') }}" class="text-white/80 hover:text-white px-3 py-2 text-sm font-medium transition-all duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-pink-500 to-purple-500 hover:opacity-90 text-white px-4 py-2 rounded-full text-sm font-medium transition-all duration-200">
                        Register
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-white/80 hover:text-white focus:outline-none transition-all duration-200">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-48 py-2 bg-black/90 backdrop-blur-xl rounded-xl shadow-lg border border-white/10"
                             style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10">
                                Profile
                            </a>
                            @if (Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10">
                                    Admin Dashboard
                                </a>
                            @endif
                            <a href="{{ route('tickets.index') }}" class="block px-4 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10">
                                My Tickets
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="text-white/80 hover:text-white focus:outline-none">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" class="sm:hidden bg-black/90 backdrop-blur-xl border-t border-white/10" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/#lineup" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                Artists
            </a>
            <a href="/#events" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                Events
            </a>
            <a href="/#tickets" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                Tickets
            </a>
            <a href="/#faq" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                FAQ
            </a>
            
            <!-- Theme Toggle (Mobile) -->
            <button x-on:click="theme = theme === 'dark' ? 'light' : 'dark'" class="w-full text-left flex items-center px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                <template x-if="theme==='dark'">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Light Mode</span>
                    </div>
                </template>
                <template x-if="theme==='light'">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <span>Dark Mode</span>
                    </div>
                </template>
            </button>
            
            <!-- Authentication Links (Mobile) -->
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                    Register
                </a>
            @else
                <div class="border-t border-white/10 pt-2 mt-2">
                    <div class="px-3 py-2 text-white font-medium">{{ Auth::user()->name }}</div>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                        Profile
                    </a>
                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                            Admin Dashboard
                        </a>
                    @endif
                    <a href="{{ route('tickets.index') }}" class="block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                        My Tickets
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-md text-base font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>

<!-- Spacer for fixed navbar -->
<div class="h-16"></div>
