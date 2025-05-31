<x-app-layout>
    <!-- Hero Banner with Glassmorphism -->
    <section class="relative min-h-screen" data-aos="fade-in" id="home">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 opacity-90"></div>
        
        <!-- Animated Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
            <div class="absolute top-1/2 right-1/3 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-3000"></div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-24 right-6 hidden md:block">
            <div class="relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-purple-500 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                <div class="relative px-7 py-4 bg-black bg-opacity-80 backdrop-blur-md rounded-lg">
                    <div class="text-center">
                        <div class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-purple-500">SOUNDWAVE</div>
                        <div class="text-white text-sm mt-1">JUNE 2025</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="relative min-h-screen flex items-center justify-center px-4">
            <div class="text-center space-y-8 max-w-4xl">
                <h1 class="text-6xl md:text-8xl font-bold text-white leading-tight tracking-tight" data-aos="zoom-in">
                    SOUNDWAVE<br/>FEST <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-purple-500">2025</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Experience the ultimate music festival vibes with your favorite artists 🎵
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                    @auth
                        <a href="{{ route('tickets.index') }}" class="px-8 py-4 bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 rounded-full text-white font-semibold transition-all duration-300 shadow-lg hover:shadow-pink-500/25">
                            Get Your Tickets 🎟️
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 rounded-full text-white font-semibold transition-all duration-300 shadow-lg hover:shadow-pink-500/25">
                            Login to Buy Tickets 🎟️
                        </a>
                    @endauth
                    <a href="{{ route('artists.index') }}" class="px-8 py-4 bg-white/10 backdrop-blur-lg rounded-full text-white font-semibold hover:bg-white/20 transition-all duration-300 border border-white/30">
                        View Artists 🎤
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Artists Section -->
    <section id="lineup" class="py-20 bg-gradient-to-b from-black to-purple-900 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-center mb-12">
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 mr-4"></div>
                <h2 class="text-4xl font-bold text-center text-white" data-aos="fade-up">Featured Artists 🌟</h2>
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 ml-4"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($featuredArtists as $artist)
                    <!-- Artist Card -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 100 }}">
                        <a href="{{ route('artists.show', $artist) }}" class="block">
                            <div class="relative overflow-hidden rounded-2xl shadow-lg shadow-purple-900/20">
                                @if($artist->image)
                                    <img src="{{ Storage::url($artist->image) }}" alt="{{ $artist->name }}" 
                                        class="w-full h-[400px] object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-[400px] bg-gradient-to-r from-purple-600 to-pink-600 transform group-hover:scale-110 transition-transform duration-500"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-3xl font-bold text-white mb-2">{{ $artist->name }}</h3>
                                    <p class="text-white/80">{{ $artist->genre ?? 'Featured Artist' }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 text-center">
                        <p class="text-white/80">No featured artists at the moment. Check back later!</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('artists.index') }}" class="px-8 py-4 bg-white/10 backdrop-blur-lg rounded-full text-white font-semibold hover:bg-white/20 transition-all duration-300 border border-white/30 inline-block">
                    View All Artists
                </a>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section id="events" class="py-20 bg-gradient-to-b from-purple-900 to-black scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-center mb-12">
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 mr-4"></div>
                <h2 class="text-4xl font-bold text-center text-white" data-aos="fade-up">Upcoming Events 🎫</h2>
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 ml-4"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($upcomingEvents as $event)
                    <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 100 }}">
                        <a href="{{ route('events.show', ['event' => $event->id]) }}" class="block">
                            <div class="relative p-8 rounded-2xl bg-white/15 backdrop-blur-xl border border-white/30 hover:bg-white/20 transition-all duration-300 shadow-lg shadow-purple-900/20 hover:shadow-xl hover:shadow-purple-900/30 transform hover:-translate-y-1">
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-2xl"></div>
                                <div class="relative">
                                    <h3 class="text-2xl font-bold text-white mb-4">{{ $event->name }}</h3>
                                    <div class="text-white/80 mb-4">
                                        <div class="flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $event->event_date->format('F j, Y - g:i A') }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $event->venue }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mt-6">
                                        <div class="text-3xl font-bold text-white">Rp {{ number_format($event->price, 0) }}</div>
                                        <div class="text-white group-hover:underline">View Details →</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 text-center">
                        <p class="text-white/80">No upcoming events at the moment. Check back later!</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('events.index') }}" class="px-8 py-4 bg-white/10 backdrop-blur-lg rounded-full text-white font-semibold hover:bg-white/20 transition-all duration-300 border border-white/30 inline-block">
                    View All Events
                </a>
            </div>
        </div>
    </section>

    <!-- Purchase Ticket Section -->
    <section id="tickets" class="py-20 bg-black scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-center mb-12">
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 mr-4"></div>
                <h2 class="text-4xl font-bold text-center text-white" data-aos="fade-up">Get Your Tickets 🎫</h2>
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 ml-4"></div>
            </div>
            <div class="bg-gradient-to-br from-purple-900/40 to-pink-900/40 backdrop-blur-lg rounded-2xl p-10 border border-white/20 shadow-xl shadow-purple-900/10" data-aos="fade-up">
                <div class="text-center space-y-6">
                    <h3 class="text-3xl font-bold text-white">Ready to experience amazing events?</h3>
                    <p class="text-white/80 text-lg max-w-2xl mx-auto">Browse our ticket collection and find the right one for you!</p>
                    @auth
                        <a href="{{ route('tickets.index') }}" 
                           class="inline-block px-10 py-4 bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-full font-semibold hover:from-pink-600 hover:to-purple-600 transition-all shadow-lg hover:shadow-pink-500/25">
                            Browse All Tickets
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-block px-10 py-4 bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-full font-semibold hover:from-pink-600 hover:to-purple-600 transition-all shadow-lg hover:shadow-pink-500/25">
                            Login to Browse Tickets
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-gradient-to-b from-black to-purple-900 scroll-mt-16">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex items-center justify-center mb-12">
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 mr-4"></div>
                <h2 class="text-4xl font-bold text-center text-white" data-aos="fade-up">FAQ ❓</h2>
                <div class="h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent w-16 ml-4"></div>
            </div>
            <div class="space-y-6" data-aos="fade-up">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg shadow-purple-900/10 hover:bg-white/15 transition-all duration-300">
                    <h3 class="text-xl font-bold text-white mb-2">Can I get a refund? 💰</h3>
                    <p class="text-white/80">Tickets are non-refundable and non-transferable.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg shadow-purple-900/10 hover:bg-white/15 transition-all duration-300">
                    <h3 class="text-xl font-bold text-white mb-2">Age Restrictions 🔞</h3>
                    <p class="text-white/80">The event is open for all ages, but attendees under 15 should be accompanied by an adult.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg shadow-purple-900/10 hover:bg-white/15 transition-all duration-300">
                    <h3 class="text-xl font-bold text-white mb-2">Outside Food & Drinks 🥤</h3>
                    <p class="text-white/80">Outside food and beverages are not allowed. Food stalls will be available inside the venue.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-black text-center" data-aos="fade-up">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex justify-center space-x-6 mb-8">
                <a href="https://instagram.com" target="_blank" class="text-white/80 hover:text-pink-500 transition-colors">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="https://twitter.com" target="_blank" class="text-white/80 hover:text-blue-400 transition-colors">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a href="https://tiktok.com" target="_blank" class="text-white/80 hover:text-purple-400 transition-colors">
                    <span class="sr-only">TikTok</span>
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    </svg>
                </a>
            </div>
            <div class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-500 mb-2">SOUNDWAVE FEST</div>
            <p class="text-white/60">© 2025 Soundwave Fest. All rights reserved.</p>
        </div>
    </footer>

    <!-- Add this to your layout or include in your assets -->
    <style>
        html {
            scroll-behavior: smooth;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-3000 {
            animation-delay: 3s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .scroll-mt-16 {
            scroll-margin-top: 6rem;
        }
        
        /* Improved scrolling for section anchors */
        @media (min-width: 768px) {
            .scroll-mt-16 {
                scroll-margin-top: 8rem;
            }
        }
    </style>
</x-app-layout> 