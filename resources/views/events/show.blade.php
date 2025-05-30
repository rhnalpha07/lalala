<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Event Header -->
                <div class="relative">
                    <!-- Banner Image or Gradient Background -->
                    <div class="h-64 w-full overflow-hidden">
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" 
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-purple-600 to-pink-600"></div>
                        @endif
                    </div>
                    
                    <!-- Event Title & Basic Info Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <div class="max-w-4xl">
                            <h1 class="text-4xl md:text-5xl font-bold mb-2">{{ $event->name }}</h1>
                            <div class="flex flex-wrap gap-4 items-center text-white/90">
                                <div class="flex items-center">
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
                        </div>
                    </div>
                </div>
                
                <!-- Admin Controls -->
                @auth
                    @if(auth()->user()->is_admin)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4">
                            <div class="max-w-4xl mx-auto flex flex-wrap gap-4">
                                <a href="{{ route('events.edit', $event) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                    Edit Event
                                </a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                        Delete Event
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
                
                <!-- Event Content -->
                <div class="p-8">
                    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Event Details -->
                        <div class="md:col-span-2">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About This Event</h2>
                            <div class="prose max-w-none dark:prose-invert mb-8">
                                @if($event->description)
                                    <div class="text-gray-800 dark:text-gray-200">
                                        {!! $event->description !!}
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400 italic">No description available.</p>
                                @endif
                            </div>
                            
                            <!-- Featuring Artists -->
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Featured Artist</h2>
                            @if($event->artist)
                                <div class="flex items-center space-x-4 mb-8">
                                    <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700">
                                        @if($event->artist->image)
                                            <img src="{{ Storage::url($event->artist->image) }}" alt="{{ $event->artist->name }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 dark:text-gray-300">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('artists.show', $event->artist) }}" class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                            {{ $event->artist->name }}
                                        </a>
                                        @if($event->artist->genre)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $event->artist->genre }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic mb-8">Artist information not available.</p>
                            @endif
                            
                            <!-- Venue Information -->
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Venue Information</h2>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 mb-8">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $event->venue }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $event->venue_address ?? 'Address not specified' }}</p>
                                @if($event->venue_address)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->venue_address) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        View on Map
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Ticket Information Sidebar -->
                        <div class="md:col-span-1">
                            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 sticky top-8">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tickets</h2>
                                <div class="mb-4">
                                    <span class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($event->price, 0) }}</span>
                                </div>
                                
                                <div class="space-y-4">
                                    @if($event->event_date > now())
                                        @if($event->availableTickets()->count() > 0)
                                            <div class="flex items-center text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    {{ $event->availableTickets()->count() }} tickets available
                                                </span>
                                            </div>
                                            
                                            @auth
                                                <form action="{{ route('tickets.index') }}" method="GET">
                                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                                    <button type="submit" 
                                                       class="block w-full text-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                                                        Buy Tickets
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" 
                                                   class="block w-full text-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                                                   Log in to Buy Tickets
                                                </a>
                                            @endauth
                                        @else
                                            <div class="flex items-center text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    Tickets sold out
                                                </span>
                                            </div>
                                            
                                            <button disabled 
                                                    class="block w-full text-center px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                                                Sold Out
                                            </button>
                                        @endif
                                    @else
                                        <div class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">
                                                Event has ended
                                            </span>
                                        </div>
                                        
                                        <button disabled 
                                                class="block w-full text-center px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                                            Event Ended
                                        </button>
                                    @endif
                                    
                                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Share This Event</h3>
                                        <div class="flex space-x-4">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('events.show', $event)) }}" 
                                               target="_blank" 
                                               class="text-blue-600 hover:text-blue-800">
                                                <span class="sr-only">Facebook</span>
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('events.show', $event)) }}&text={{ urlencode($event->name) }}" 
                                               target="_blank" 
                                               class="text-sky-500 hover:text-sky-600">
                                                <span class="sr-only">Twitter</span>
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                                </svg>
                                            </a>
                                            <a href="https://wa.me/?text={{ urlencode($event->name . ' - ' . route('events.show', $event)) }}" 
                                               target="_blank" 
                                               class="text-green-600 hover:text-green-700">
                                                <span class="sr-only">WhatsApp</span>
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M21.11 2.89A12.91 12.91 0 0012 0 12.91 12.91 0 002.89 2.89 12.91 12.91 0 000 12c0 2.25.58 4.39 1.59 6.26L0 24l5.97-1.56A12.98 12.98 0 0012 24c6.63 0 12-5.37 12-12 0-3.31-1.34-6.31-3.51-8.49l.62-.62zM12 22a11 11 0 01-5.61-1.53l-.4-.24-4.15 1.09 1.11-4.05-.26-.42A11 11 0 1112 22zM8.1 7.25c-.25 0-.56.05-.84.33-.28.28-1.07 1.04-1.07 2.54 0 1.5 1.09 2.95 1.24 3.15.15.2 2.09 3.19 5.06 4.47 2.5 1.07 3 .86 3.54.8.55-.05 1.77-.72 2.02-1.42.25-.7.25-1.3.18-1.42-.07-.12-.28-.19-.59-.33s-1.82-.9-2.1-1a.5.5 0 00-.71.23c-.2.37-.75 1.17-.92 1.4-.17.24-.34.27-.64.09-.3-.18-1.26-.46-2.4-1.47-.88-.79-1.48-1.76-1.66-2.06-.17-.3-.02-.47.13-.62.13-.13.3-.34.45-.51.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.74-1.78-1.01-2.44-.27-.65-.54-.56-.74-.57h-.63z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('events.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to all events
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 