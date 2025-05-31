<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Tickets</h1>
                        <p class="text-gray-600 dark:text-gray-400">View all your purchased tickets</p>
                    </div>

                    @if($transactions->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No tickets found</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">You haven't purchased any tickets yet.</p>
                            <div class="mt-6">
                                <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Browse Events
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($transactions as $transaction)
                                @if($transaction->ticket && $transaction->ticket->event)
                                    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                        <!-- Event Image (if available) -->
                                        @if($transaction->ticket->event->image_url)
                                            <div class="h-48 overflow-hidden">
                                                <img src="{{ $transaction->ticket->event->image_url }}" alt="{{ $transaction->ticket->event->name }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="h-48 bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center">
                                                <span class="text-white text-xl font-bold">{{ $transaction->ticket->event->name }}</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Ticket Details -->
                                        <div class="p-5">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $transaction->ticket->event->name }}</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $transaction->ticket->event->event_date ? $transaction->ticket->event->event_date->format('D, M j, Y - g:i A') : 'Date not available' }}
                                                    </p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $transaction->ticket->event->venue }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 uppercase">
                                                    {{ $transaction->ticket->ticket_type }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">Ticket #</p>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->ticket->ticket_number }}</p>
                                                    </div>
                                                    @if($transaction->ticket->seat_number)
                                                        <div>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">Seat</p>
                                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->ticket->seat_number }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div class="mt-4 flex justify-between items-center">
                                                    <div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">Price</p>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->ticket->price, 0) }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">Purchased</p>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->created_at->format('M j, Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-5 flex justify-between">
                                                <a href="{{ route('tickets.show', $transaction->ticket) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View Ticket
                                                </a>
                                                <a href="{{ route('transactions.show', $transaction) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/30 hover:bg-indigo-200 dark:hover:bg-indigo-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View Receipt
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 