<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Admin' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <style>
        /* Override any dark mode styles */
        html.dark {
            color-scheme: light !important;
        }
        
        body, .bg-gray-50, .bg-white, .bg-gray-100, .bg-gray-200 {
            background-color: var(--color) !important;
            color: var(--text-color) !important;
        }
        
        :root {
            --color: #f9fafb;
            --text-color: #111827;
            --text-color-secondary: #4b5563;
            --border-color: #e5e7eb;
            --highlight-color: #3b82f6;
        }
        
        /* Ensure text colors are visible on light backgrounds */
        .text-gray-700, .text-gray-800, .text-gray-900 {
            color: var(--text-color) !important;
        }
        
        .text-gray-500, .text-gray-600 {
            color: var(--text-color-secondary) !important;
        }
        
        /* Ensure border colors are visible */
        .border, .border-gray-200 {
            border-color: var(--border-color) !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Force Light Mode -->
    <script>
        // Force light mode for admin panel regardless of user settings
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
        localStorage.setItem('theme', 'light');
        
        // This ensures that even if there are Alpine.js or other scripts 
        // trying to manage theme, they will be overridden
        window.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        });
    </script>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen bg-gray-50">
        <!-- Mobile sidebar backdrop -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition ease-out duration-150" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100" 
            x-transition:leave="transition ease-in duration-150" 
            x-transition:leave-start="opacity-100" 
            x-transition:leave-end="opacity-0" 
            class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        <div 
            x-cloak
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r overflow-y-auto transition-transform duration-300 ease-in-out transform -translate-x-full lg:translate-x-0">
            <div class="flex items-center justify-between h-16 bg-white border-b px-4">
                <span class="text-xl font-semibold text-blue-600">Admin Panel</span>
                <button @click="sidebarOpen = false" class="p-1 text-gray-500 rounded-md lg:hidden hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mt-2">
                <div class="px-6 py-2">
                    <p class="text-xs uppercase tracking-wider text-gray-500">Main</p>
                </div>
                <nav class="mt-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-l-4 border-blue-500 text-blue-700 font-medium' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </nav>
                
                <div class="px-6 py-2 mt-3">
                    <p class="text-xs uppercase tracking-wider text-gray-500">Content Management</p>
                </div>
                
                <nav class="mt-1">
                    <div x-data="{ open: {{ request()->routeIs('admin.events.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-6 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.events.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.events.*') ? 'text-blue-500' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Events</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform {{ request()->routeIs('admin.events.*') ? 'text-blue-500' : 'text-gray-500' }}" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="pl-6 mt-1 bg-gray-50">
                            <a href="{{ route('admin.events.index') }}" class="flex items-center px-6 py-2 text-sm text-gray-600 hover:text-blue-700 {{ request()->routeIs('admin.events.index') && !request()->has('status') ? 'text-blue-700 font-medium' : '' }}">
                                <span class="mr-2 {{ request()->routeIs('admin.events.index') && !request()->has('status') ? 'text-blue-500' : 'text-gray-500' }}">•</span>All Events
                            </a>
                            <a href="{{ route('admin.events.create') }}" class="flex items-center px-6 py-2 text-sm text-gray-600 hover:text-blue-700 {{ request()->routeIs('admin.events.create') ? 'text-blue-700 font-medium' : '' }}">
                                <span class="mr-2 {{ request()->routeIs('admin.events.create') ? 'text-blue-500' : 'text-gray-500' }}">•</span>Add New Event
                            </a>
                            <a href="{{ route('admin.events.index', ['status' => 'upcoming']) }}" class="flex items-center px-6 py-2 text-sm text-gray-600 hover:text-blue-700 {{ request()->fullUrlIs('*events*status=upcoming*') ? 'text-blue-700 font-medium' : '' }}">
                                <span class="mr-2 {{ request()->fullUrlIs('*events*status=upcoming*') ? 'text-blue-500' : 'text-gray-500' }}">•</span>Upcoming Events
                            </a>
                        </div>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('admin.artists.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-6 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.artists.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.artists.*') ? 'text-blue-500' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Artists</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform {{ request()->routeIs('admin.artists.*') ? 'text-blue-500' : 'text-gray-500' }}" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="pl-6 mt-1 bg-gray-50">
                            <a href="{{ route('admin.artists.index') }}" class="flex items-center px-6 py-2 text-sm text-gray-600 hover:text-blue-700 {{ request()->routeIs('admin.artists.index') && !request()->has('type') ? 'text-blue-700 font-medium' : '' }}">
                                <span class="mr-2 {{ request()->routeIs('admin.artists.index') && !request()->has('type') ? 'text-blue-500' : 'text-gray-500' }}">•</span>All Artists
                            </a>
                            <a href="{{ route('admin.artists.create') }}" class="flex items-center px-6 py-2 text-sm text-gray-600 hover:text-blue-700 {{ request()->routeIs('admin.artists.create') ? 'text-blue-700 font-medium' : '' }}">
                                <span class="mr-2 {{ request()->routeIs('admin.artists.create') ? 'text-blue-500' : 'text-gray-500' }}">•</span>Add New Artist
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.profile') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.profile') ? 'bg-blue-50 border-l-4 border-blue-500 text-blue-700 font-medium' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.profile') ? 'text-blue-500' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>My Profile</span>
                    </a>
                </nav>
                
                <div class="px-6 py-2 mt-3">
                    <p class="text-xs uppercase tracking-wider text-gray-500">System</p>
                </div>
                
                <nav class="mt-1">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 text-left">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button 
                                @click="sidebarOpen = true" 
                                class="p-2 rounded-md lg:hidden text-gray-600 hover:bg-gray-100"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <div class="ml-4 lg:ml-0">
                                <h2 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="ml-3 relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700">
                                            {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                                        </div>
                                        <span class="ml-2 text-gray-700">{{ Auth::guard('admin')->user()->name }}</span>
                                        <svg class="ml-1 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>
                                <div 
                                    x-show="open" 
                                    @click.outside="open = false" 
                                    x-transition:enter="transition ease-out duration-100" 
                                    x-transition:enter-start="transform opacity-0 scale-95" 
                                    x-transition:enter-end="transform opacity-100 scale-100" 
                                    x-transition:leave="transition ease-in duration-75" 
                                    x-transition:leave-start="transform opacity-100 scale-100" 
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                >
                                    <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-10 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Breadcrumbs -->
                    <div class="mb-6">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                @if(isset($breadcrumbs))
                                    @foreach($breadcrumbs as $label => $url)
                                        <li>
                                            <div class="flex items-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                <a href="{{ $url }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $label }}</a>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                                @if(isset($title) && (!isset($breadcrumbs) || !array_key_exists($title, $breadcrumbs ?? [])))
                                    <li aria-current="page">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $title }}</span>
                                        </div>
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                                <svg class="h-4 w-4 fill-current text-green-700" role="button" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                                <svg class="h-4 w-4 fill-current text-red-700" role="button" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                            </button>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html> 