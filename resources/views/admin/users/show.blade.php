<x-admin-layout>
    <x-slot name="title">
        User Details
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">User Profile</h1>
            <p class="mt-1 text-gray-500">View and manage user information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit User
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Information -->
        <div class="lg:col-span-2 grid grid-cols-1 gap-6">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-20 w-20 bg-gray-200 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 font-medium text-3xl">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-medium text-gray-900">{{ $user->name }}</h2>
                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </div>
                    </div>
                </div>

                <dl class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">User ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Joined On</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tickets Purchased</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $ticketsPurchased }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Spent</dt>
                        <dd class="mt-1 text-sm text-gray-900">${{ number_format($totalSpent, 2) }}</dd>
                    </div>
                </dl>
                
                <div class="mt-6 flex space-x-3">
                    <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="return confirm('Are you sure you want to {{ $user->is_admin ? 'remove' : 'grant' }} admin privileges?')">
                            {{ $user->is_admin ? 'Remove Admin Status' : 'Make Admin' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Recent Transactions -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Transactions</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($user->transactions()->with(['ticket', 'ticket.event'])->latest()->take(5)->get() as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $transaction->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($transaction->ticket && $transaction->ticket->event)
                                                {{ $transaction->ticket->event->name }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">${{ number_format($transaction->amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full 
                                            {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $transaction->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $transaction->payment_status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $transaction->payment_status === 'refunded' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('admin.transactions.index', ['user_id' => $user->id]) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        View All Transactions →
                    </a>
                </div>
            </div>
        </div>

        <!-- Activity Stats -->
        <div class="space-y-6">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">User Activity</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Spent</h3>
                        <div class="text-3xl font-semibold text-gray-900">${{ number_format($totalSpent, 2) }}</div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tickets Purchased</h3>
                        <div class="text-3xl font-semibold text-gray-900">{{ $ticketsPurchased }}</div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Last Activity</h3>
                        <div class="text-lg font-medium text-gray-900">
                            @if($user->transactions()->latest()->first())
                                {{ $user->transactions()->latest()->first()->created_at->format('M d, Y') }}
                                <div class="text-sm text-gray-500">{{ $user->transactions()->latest()->first()->created_at->diffForHumans() }}</div>
                            @else
                                No activity
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('admin.users.edit', $user) }}" class="block w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                        Edit User Profile
                    </a>
                    
                    <a href="{{ route('admin.transactions.index', ['user_id' => $user->id]) }}" class="block w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                        View Transactions
                    </a>

                    <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ $user->is_admin ? 'Remove Admin Status' : 'Make Admin' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 