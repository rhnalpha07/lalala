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

        <!-- Alpine.js Countdown Script -->
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('countdown', () => ({
                    days: '00',
                    hours: '00',
                    minutes: '00',
                    seconds: '00',
                    init() {
                        // Set the festival date (June 15, 2025)
                        const festivalDate = new Date('June 15, 2025 00:00:00').getTime();
                        
                        setInterval(() => {
                            const now = new Date().getTime();
                            const distance = festivalDate - now;
                            
                            if (distance > 0) {
                                this.days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                                this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                                this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                                this.seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
                            }
                        }, 1000);
                    }
                }));
            });
        </script>
    </body>
</html>
