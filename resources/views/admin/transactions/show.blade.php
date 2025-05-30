<x-admin-layout>
    <x-slot name="title">
        Transaction Details
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Transaction #{{ $transaction->id }}</h1>
            <span class="ml-3 px-3 py-1 text-sm font-semibold rounded-full 
                {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ $transaction->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                {{ $transaction->payment_status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                {{ $transaction->payment_status === 'refunded' ? 'bg-gray-100 text-gray-800' : '' }}">
                {{ ucfirst($transaction->payment_status) }}
            </span>
        </div>
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Transactions
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Transaction Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Transaction Details</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Transaction Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->created_at->format('M d, Y h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($transaction->payment_method) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">${{ number_format($transaction->amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->payment_id ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->updated_at->format('M d, Y h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $transaction->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $transaction->payment_status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $transaction->payment_status === 'refunded' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500">Update Status</h3>
                    <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="mt-2 flex space-x-2">
                        @csrf
                        @method('PUT')
                        <select name="payment_status" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="pending" {{ $transaction->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $transaction->payment_status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $transaction->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $transaction->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ticket Details -->
            @if($transaction->ticket)
                <div class="mt-6 bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Ticket Details</h2>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ticket Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->ticket->ticket_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ticket Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($transaction->ticket->ticket_type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Seat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->ticket->seat_number ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Price</dt>
                                <dd class="mt-1 text-sm text-gray-900">${{ number_format($transaction->ticket->price, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $transaction->ticket->status === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $transaction->ticket->status === 'reserved' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $transaction->ticket->status === 'sold' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($transaction->ticket->status) }}
                                    </span>
                                </dd>
                            </div>
                            @if($transaction->ticket->event)
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Event</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('admin.events.show', $transaction->ticket->event) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $transaction->ticket->event->name }}
                                        </a>
                                        <span class="block text-xs text-gray-500 mt-1">
                                            {{ $transaction->ticket->event->event_date->format('M d, Y h:i A') }}
                                        </span>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            @endif
        </div>

        <!-- User Info -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Customer Information</h2>
            </div>
            <div class="p-6">
                @if($transaction->user)
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 font-medium text-2xl">{{ substr($transaction->user->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $transaction->user->name }}</h3>
                            <div class="text-sm text-gray-500">{{ $transaction->user->email }}</div>
                        </div>
                    </div>

                    <dl class="mt-6 space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->user->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->user->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Role</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->user->is_admin ? 'Admin' : 'User' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Actions</dt>
                            <dd class="mt-1 text-sm">
                                <a href="{{ route('admin.users.show', $transaction->user) }}" class="text-blue-600 hover:underline">View Full Profile</a>
                            </dd>
                        </div>
                    </dl>
                @else
                    <div class="flex items-center justify-center py-6">
                        <div class="text-center">
                            <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Guest Purchase</h3>
                            <p class="mt-1 text-sm text-gray-500">This transaction was made by a guest user.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Transaction Button -->
    @if($transaction->payment_status !== 'completed')
        <div class="mt-6">
            <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Transaction
                </button>
            </form>
        </div>
    @endif
</x-admin-layout> 