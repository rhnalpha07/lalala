<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Artists</h2>
                    @auth
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('artists.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Add New Artist
                        </a>
                        @endif
                    @endauth
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($artists as $artist)
                        <div class="group bg-white dark:bg-gray-900 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                            <a href="{{ route('artists.show', $artist) }}" class="block">
                                <div class="h-64 overflow-hidden">
                                    @if ($artist->image)
                                        <img src="{{ Storage::url($artist->image) }}" alt="{{ $artist->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 dark:text-gray-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $artist->name }}</h3>
                                    @if($artist->genre)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $artist->genre }}</p>
                                    @endif
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-indigo-600 dark:text-indigo-400">
                                            {{ $artist->events->count() }} {{ Str::plural('event', $artist->events->count()) }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">View details →</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-12 h-12 text-gray-400 dark:text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No artists found</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Get started by creating a new artist.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $artists->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 