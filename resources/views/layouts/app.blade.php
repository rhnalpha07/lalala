<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Soundwave Fest') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body x-data="{ theme: localStorage.getItem('theme') || 'dark' }"
          x-init="document.documentElement.classList.add(theme); $watch('theme', value => { document.documentElement.classList.toggle('dark', value === 'dark'); localStorage.setItem('theme', value); })"
          :class="{ 'dark': theme === 'dark' }"
          class="font-sans antialiased bg-white dark:bg-black transition-colors duration-500">
        <div class="min-h-screen bg-gradient-to-br from-pink-100 to-purple-200 dark:from-black dark:to-[#0d0d25] transition-colors duration-500">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
