<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="max-w-3xl mx-auto">
                        <!-- Ticket Header -->
                        <div class="text-center mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Ticket Details</h1>
                            <p class="text-gray-600 dark:text-gray-400">{{ $ticket->ticket_number }}</p>
                        </div>

                        <!-- Ticket Status Badge -->
                        <div class="flex justify-center mb-8">
                            @if($ticket->status == 'available')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    Available
                                </span>
                            @elseif($ticket->status == 'reserved')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Reserved
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Sold
                                </span>
                            @endif
                        </div>

                        <!-- Ticket Card -->
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl overflow-hidden shadow-xl">
                            <!-- Event Banner -->
                            <div class="h-32 bg-gradient-to-r from-pink-600 to-purple-600 relative">
                                @if($ticket->event->image)
                                    <img src="{{ Storage::url($ticket->event->image) }}" alt="{{ $ticket->event->name }}" 
                                        class="w-full h-full object-cover mix-blend-overlay">
                                @endif
                                <div class="absolute inset-0 p-6 flex items-center">
                                    <div>
                                        <h2 class="text-2xl font-bold text-white">{{ $ticket->event->name }}</h2>
                                        <p class="text-white/80 text-sm">{{ $ticket->event->event_date->format('F j, Y - g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Ticket Details -->
                            <div class="p-6 bg-white dark:bg-gray-900 border-t border-white/20">
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Event</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $ticket->event->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Date & Time</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $ticket->event->event_date->format('M d, Y') }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->event->event_date->format('g:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Venue</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $ticket->event->venue }}</p>
                                        @if($ticket->event->venue_address)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->event->venue_address }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white capitalize">{{ $ticket->ticket_type }}</p>
                                        @if($ticket->seat_number)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Seat: {{ $ticket->seat_number }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Rp {{ number_format($ticket->price, 0) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Ticket #</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $ticket->ticket_number }}</p>
                                    </div>
                                </div>
                                
                                <!-- QR Code Placeholder -->
                                <div class="mt-6 flex justify-center">
                                    <div class="w-40 h-40 bg-white p-2 rounded">
                                        <!-- In a real app, generate a QR code with the ticket info -->
                                        <div class="border-4 border-gray-900 w-full h-full flex items-center justify-center">
                                            <p class="text-xs text-center font-mono">
                                                QR Code for<br>{{ $ticket->ticket_number }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Featured Artist -->
                                @if($ticket->event->artist)
                                    <div class="mt-6 flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                            @if($ticket->event->artist->image)
                                                <img src="{{ Storage::url($ticket->event->artist->image) }}" alt="{{ $ticket->event->artist->name }}" 
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Featuring</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $ticket->event->artist->name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-between">
                            <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Tickets
                            </a>

                            <div class="space-x-2">
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-lg text-white hover:bg-indigo-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit Ticket
                                        </a>
                                    @endif
                                @endauth
                                
                                @if($ticket->status == 'available')
                                    <form action="{{ route('tickets.purchase', $ticket) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 rounded-lg text-white hover:bg-green-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Purchase Ticket
                                        </button>
                                    </form>
                                @elseif($ticket->status == 'sold')
                                    <!-- View Transaction Button (if sold) -->
                                    @if($ticket->transaction)
                                        <a href="{{ route('transactions.show', $ticket->transaction) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg text-white hover:bg-blue-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            View Transaction
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 