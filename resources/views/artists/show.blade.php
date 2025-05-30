<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative">
                    <!-- Cover Image or Gradient Background -->
                    <div class="h-64 bg-gradient-to-r from-pink-600 to-purple-700 w-full"></div>
                    
                    <!-- Artist Image and Basic Info -->
                    <div class="px-6 -mt-20">
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Artist Image -->
                            <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white dark:border-gray-900 shadow-xl bg-white dark:bg-gray-700 flex-shrink-0 z-10">
                                @if($artist->image)
                                    <img src="{{ Storage::url($artist->image) }}" alt="{{ $artist->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 dark:text-gray-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Artist Info -->
                            <div class="flex flex-col pt-6 justify-end">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $artist->name }}</h1>
                                @if($artist->genre)
                                    <p class="text-indigo-600 dark:text-indigo-400 font-medium mt-1">{{ $artist->genre }}</p>
                                @endif
                                
                                <div class="flex space-x-4 mt-4">
                                    @auth
                                        @if(auth()->user()->is_admin)
                                            <a href="{{ route('artists.edit', $artist) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                                Edit Artist
                                            </a>
                                            <form action="{{ route('artists.destroy', $artist) }}" method="POST" 
                                                onsubmit="return confirm('Are you sure you want to delete this artist?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Artist Bio -->
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">About</h2>
                    @if($artist->bio)
                        <div class="prose max-w-none dark:prose-invert">
                            <p class="text-gray-800 dark:text-gray-200">{{ $artist->bio }}</p>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 italic">No biography available yet.</p>
                    @endif
                </div>
                
                <!-- Upcoming Events -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Upcoming Events</h2>
                    
                    @if($artist->events->where('event_date', '>=', now())->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($artist->events->where('event_date', '>=', now()) as $event)
                                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('events.show', $event) }}" class="block">
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $event->name }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                <span class="inline-block mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                                {{ $event->event_date->format('F j, Y - g:i A') }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                <span class="inline-block mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </span>
                                                {{ $event->venue }}
                                            </p>
                                            <div class="flex justify-between items-center">
                                                <span class="text-indigo-600 dark:text-indigo-400 font-semibold">
                                                    Rp {{ number_format($event->price, 0) }}
                                                </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">View details →</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-12 h-12 text-gray-400 dark:text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No upcoming events</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Check back later for updates.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Past Events -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Past Events</h2>
                    
                    @if($artist->events->where('event_date', '<', now())->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($artist->events->where('event_date', '<', now()) as $event)
                                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 opacity-75">
                                    <a href="{{ route('events.show', $event) }}" class="block">
                                        <div class="p-6">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $event->name }}</h3>
                                                <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-xs rounded-full text-gray-700 dark:text-gray-300">Past</span>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                <span class="inline-block mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                                {{ $event->event_date->format('F j, Y - g:i A') }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                <span class="inline-block mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </span>
                                                {{ $event->venue }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 italic">No past events found.</p>
                    @endif
                </div>
            </div>
            
            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('artists.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to all artists
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 