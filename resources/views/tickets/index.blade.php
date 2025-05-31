<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tickets</h2>
                    @auth
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('tickets.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Add New Ticket
                        </a>
                        @endif
                    @endauth
                </div>

                <!-- Filter Section -->
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                    <form action="{{ route('tickets.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="event_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event</label>
                            <select id="event_id" name="event_id" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-full">
                                <option value="">All Events</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" @if(request('event_id') == $event->id) selected @endif>
                                        {{ $event->name }} ({{ $event->event_date->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="ticket_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ticket Type</label>
                            <select id="ticket_type" name="ticket_type" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-full">
                                <option value="">All Types</option>
                                <option value="regular" @if(request('ticket_type') == 'regular') selected @endif>Regular</option>
                                <option value="vip" @if(request('ticket_type') == 'vip') selected @endif>VIP</option>
                                <option value="backstage" @if(request('ticket_type') == 'backstage') selected @endif>Backstage</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select id="status" name="status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-full">
                                <option value="">All Status</option>
                                <option value="available" @if(request('status') == 'available') selected @endif>Available</option>
                                <option value="reserved" @if(request('status') == 'reserved') selected @endif>Reserved</option>
                                <option value="sold" @if(request('status') == 'sold') selected @endif>Sold</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Filter
                            </button>
                            @if(request('event_id') || request('ticket_type') || request('status'))
                                <a href="{{ route('tickets.index') }}" class="ml-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Events and Tickets Display -->
                @if($tickets->isEmpty())
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-12 h-12 mb-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No tickets found</p>
                    </div>
                @else
                    @if(request('event_id'))
                        <!-- Show tickets for a specific event -->
                        <div class="space-y-8">
                            @php
                                $event = $events->where('id', request('event_id'))->first();
                                $eventTickets = $tickets;
                                $ticketsByType = $eventTickets->groupBy('ticket_type');
                            @endphp

                            @if($event)
                                <div class="border dark:border-gray-700 rounded-lg overflow-hidden">
                                    <!-- Event Header -->
                                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b dark:border-gray-700">
                                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $event->name }}</h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="inline-flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ $event->event_date->format('M d, Y - g:i A') }}
                                                    </span>
                                                    @if($event->location)
                                                    <span class="inline-flex items-center ml-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        {{ $event->location }}
                                                    </span>
                                                    @endif
                                                </p>
                                            </div>
                                            <a href="{{ route('events.show', $event) }}" class="mt-2 md:mt-0 px-3 py-1 text-sm bg-indigo-50 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-800 transition-colors">
                                                Event Details
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Ticket Cards -->
                                    @if($eventTickets->isEmpty())
                                        <div class="p-6 text-center">
                                            <p class="text-gray-500 dark:text-gray-400">No tickets available for this event</p>
                                        </div>
                                    @else
                                        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                            @foreach(['regular', 'vip', 'backstage'] as $ticketType)
                                                @if(isset($ticketsByType[$ticketType]) && $ticketsByType[$ticketType]->isNotEmpty())
                                                    <div class="border dark:border-gray-700 rounded-lg overflow-hidden">
                                                        <div class="bg-gray-50 dark:bg-gray-800 px-4 py-2 border-b dark:border-gray-700">
                                                            <h4 class="font-medium text-gray-900 dark:text-white capitalize">{{ $ticketType }} Tickets</h4>
                                                        </div>
                                                        
                                                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                                            @foreach($ticketsByType[$ticketType] as $ticket)
                                                                <div class="p-4">
                                                                    <div class="flex justify-between">
                                                                        <div>
                                                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                                                #{{ $ticket->ticket_number }}
                                                                                @if($ticket->seat_number)
                                                                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">
                                                                                        Seat: {{ $ticket->seat_number }}
                                                                                    </span>
                                                                                @endif
                                                                            </p>
                                                                            <p class="text-sm text-gray-900 dark:text-white">
                                                                                Rp {{ number_format($ticket->price, 0) }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="flex flex-col items-end">
                                                                            @if($ticket->status == 'available')
                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                    Available
                                                                                </span>
                                                                            @elseif($ticket->status == 'reserved')
                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                                    Reserved
                                                                                </span>
                                                                            @else
                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                                    Sold
                                                                                </span>
                                                                            @endif
                                                                            <div class="mt-2 flex space-x-2">
                                                                                <a href="{{ route('tickets.show', $ticket) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                                                    View
                                                                                </a>
                                                                                
                                                                                @if($ticket->status == 'available')
                                                                                    <form action="{{ route('tickets.purchase', $ticket) }}" method="POST" class="inline">
                                                                                        @csrf
                                                                                        <button type="submit" class="text-xs text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                                                                            Buy
                                                                                        </button>
                                                                                    </form>
                                                                                @endif
                                                                                
                                                                                @auth
                                                                                    @if(auth()->user()->is_admin)
                                                                                        <a href="{{ route('tickets.edit', $ticket) }}" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                                                            Edit
                                                                                        </a>
                                                                                        
                                                                                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline"
                                                                                            onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                                                                Delete
                                                                                            </button>
                                                                                        </form>
                                                                                    @endif
                                                                                @endauth
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Show all events in card layout -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($events as $event)
                                <div class="border dark:border-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                                    <!-- Event Header with Image -->
                                    <div class="relative">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-0 right-0 bg-indigo-600 text-white px-3 py-1 rounded-bl-lg text-sm font-medium">
                                            {{ ucfirst($event->status) }}
                                        </div>
                                    </div>
                                    
                                    <!-- Event Info -->
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $event->name }}</h3>
                                        
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $event->event_date->format('M d, Y - g:i A') }}
                                        </div>
                                        
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $event->venue }}
                                        </div>
                                        
                                        @php
                                            // Get available tickets count for this event from database
                                            // Karena collection tickets hanya berisi tiket yang ada di halaman saat ini (paginated)
                                            $availableTicketsCount = App\Models\Ticket::where('event_id', $event->id)
                                                                    ->where('status', 'available')
                                                                    ->count();
                                            
                                            $totalTicketsCount = App\Models\Ticket::where('event_id', $event->id)
                                                               ->count();
                                            
                                            // Calculate percentage of tickets sold
                                            $percentageSold = $totalTicketsCount > 0 ? 100 - (($availableTicketsCount / $totalTicketsCount) * 100) : 0;
                                        @endphp
                                        
                                        <!-- Ticket Availability -->
                                        <div class="mb-3">
                                            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                                                <span>Tickets Available</span>
                                                <span>{{ $availableTicketsCount }} / {{ $totalTicketsCount }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percentageSold }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Ticket Types -->
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @php
                                                // Ambil jenis tiket langsung dari database
                                                $ticketTypes = App\Models\Ticket::where('event_id', $event->id)
                                                             ->distinct()
                                                             ->pluck('ticket_type');
                                            @endphp
                                            
                                            @foreach($ticketTypes as $type)
                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded text-xs capitalize">
                                                    {{ $type }}
                                                </span>
                                            @endforeach
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                Rp {{ number_format($event->price, 0) }}
                                            </span>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('events.show', $event) }}" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition-colors">
                                                    Details
                                                </a>
                                                <a href="{{ route('tickets.index', ['event_id' => $event->id]) }}" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors">
                                                    View Tickets
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-12 h-12 mb-4 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">No events found</p>
                                </div>
                            @endforelse
                        </div>
                    @endif

                    <!-- Pagination with query parameters preserved -->
                    <div class="mt-6">
                        {{ $tickets->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 