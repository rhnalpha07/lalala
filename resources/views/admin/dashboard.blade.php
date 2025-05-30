<x-admin-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    
    <!-- Dashboard Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Admin Dashboard</h1>
            <p class="mt-2 text-gray-600">Welcome back, {{ Auth::guard('admin')->user()->name }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Event
            </a>
            <a href="{{ route('admin.artists.create') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Artist
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Events -->
        <div class="bg-white rounded-lg shadow p-6 transition-transform transform hover:scale-105 hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-semibold">Total Events</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $stats['total_events'] }}</p>
                    <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">View all events →</a>
                </div>
            </div>
        </div>

        <!-- Total Artists -->
        <div class="bg-white rounded-lg shadow p-6 transition-transform transform hover:scale-105 hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-semibold">Total Artists</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $stats['total_artists'] }}</p>
                    <a href="{{ route('admin.artists.index') }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">View all artists →</a>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6 transition-transform transform hover:scale-105 hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-semibold">Total Users</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-lg shadow p-6 transition-transform transform hover:scale-105 hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-semibold">Upcoming Events</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $stats['upcoming_events'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Tickets -->
        <div class="bg-white rounded-lg shadow p-6 transition-transform transform hover:scale-105 hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-semibold">Total Tickets</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $stats['total_tickets'] }}</p>
                    <div class="text-xs text-gray-500">{{ $stats['sold_tickets'] }} sold</div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow p-6 transition-transform transform hover:scale-105 hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-semibold">Total Revenue</h2>
                    <p class="text-2xl font-semibold text-gray-700">${{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Latest Events -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">Latest Events</h2>
                <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all</a>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artist</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($latest_events as $event)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($event->image)
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $event->name }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($event->description, 40) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $event->artist->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $event->event_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $event->event_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $event->status === 'upcoming' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $event->status === 'ongoing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $event->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No events found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ticket Sales Chart -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">Ticket Sales Overview</h2>
                <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
            </div>
            <div class="p-6">
                <canvas id="ticketSalesChart" height="200"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('ticketSalesChart').getContext('2d');
                        
                        // Format data for Chart.js
                        const salesData = @json($ticket_sales_data);
                        const labels = salesData.map(item => item.date);
                        const totalData = salesData.map(item => item.total);
                        const soldData = salesData.map(item => item.sold);
                        
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Total Tickets',
                                        data: totalData,
                                        borderColor: '#3b82f6',
                                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                        fill: true,
                                        tension: 0.4
                                    },
                                    {
                                        label: 'Sold Tickets',
                                        data: soldData,
                                        borderColor: '#10b981',
                                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                        fill: true,
                                        tension: 0.4
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            </div>
        </div>

        <!-- Upcoming Events by Month -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">Upcoming Events by Month</h2>
            </div>
            <div class="p-6">
                @if($upcoming_events_by_month->count())
                    <div class="space-y-4">
                        @foreach($upcoming_events_by_month as $month => $count)
                            <div class="flex items-center">
                                <div class="w-1/3 text-sm text-gray-600">{{ $month }}</div>
                                <div class="w-2/3 flex items-center">
                                    <div class="relative w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="absolute top-0 left-0 h-full bg-blue-500" style="width: {{ min(100, $count / ($upcoming_events_by_month->max() ?: 1) * 100) }}%"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No upcoming events found</p>
                @endif
            </div>
        </div>

        <!-- Popular Artists -->
        <div class="bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">Popular Artists</h2>
                <a href="{{ route('admin.artists.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all</a>
            </div>
            <div class="p-6">
                @if($popular_artists->count())
                    <div class="space-y-4">
                        @foreach($popular_artists as $artist)
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($artist->image)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($artist->image) }}" alt="{{ $artist->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium text-sm">{{ substr($artist->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-grow">
                                    <div class="text-sm font-medium text-gray-900">{{ $artist->name }}</div>
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span>{{ $artist->events_count }} events</span>
                                        <span>{{ $artist->events_tickets_count ?? 0 }} tickets sold</span>
                                    </div>
                                    <div class="mt-1 relative w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="absolute top-0 left-0 h-full bg-green-500" style="width: {{ min(100, $artist->events_count / ($popular_artists->max('events_count') ?: 1) * 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No artists found</p>
                @endif
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">Recent Transactions</h2>
            </div>
            <div class="p-6">
                @if($recent_transactions->count())
                    <div class="space-y-4">
                        @foreach($recent_transactions as $transaction)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">
                                            @if($transaction->user)
                                                {{ $transaction->user->name }}
                                            @else
                                                Guest User
                                            @endif
                                        </h3>
                                        <p class="text-xs text-gray-500">
                                            {{ $transaction->created_at->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $transaction->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $transaction->payment_status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-between">
                                    <div class="text-sm text-gray-700">
                                        @if($transaction->ticket && $transaction->ticket->event)
                                            Ticket for: {{ $transaction->ticket->event->name }}
                                        @else
                                            Ticket purchase
                                        @endif
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ number_format($transaction->amount, 2) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No transactions found</p>
                @endif
            </div>
        </div>

        <!-- User Registration Stats -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">User Registrations</h2>
                <p class="text-sm text-gray-500 mt-1">{{ now()->year }} Monthly breakdown</p>
            </div>
            <div class="p-6">
                @if($user_stats->count())
                    <div class="space-y-4">
                        @foreach($user_stats as $month => $count)
                            <div class="flex items-center">
                                <div class="w-1/3 text-sm text-gray-600">{{ $month }}</div>
                                <div class="w-2/3 flex items-center">
                                    <div class="relative w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="absolute top-0 left-0 h-full bg-yellow-500" style="width: {{ min(100, $count / ($user_stats->max() ?: 1) * 100) }}%"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No user registration data available</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout> 