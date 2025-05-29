<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="max-w-3xl mx-auto">
                        <!-- Transaction Header -->
                        <div class="text-center mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Transaction Details</h1>
                            <p class="text-gray-600 dark:text-gray-400">{{ $transaction->transaction_number }}</p>
                            
                            <!-- Transaction Status Badge -->
                            <div class="flex justify-center mt-4">
                                @if($transaction->payment_status == 'completed')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Payment Completed
                                    </span>
                                @elseif($transaction->payment_status == 'pending')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Payment Pending
                                    </span>
                                @elseif($transaction->payment_status == 'failed')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        Payment Failed
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($transaction->payment_status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Transaction Info Card -->
                        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- Payment Summary -->
                            <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h2 class="text-2xl font-bold">Payment Summary</h2>
                                        <p class="text-white/80">{{ $transaction->payment_date ? $transaction->payment_date->format('F j, Y - g:i A') : 'Date not available' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-white/80">Total Amount</p>
                                        <p class="text-3xl font-bold">Rp {{ number_format($transaction->amount, 0) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Transaction Details -->
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Payment Information</h3>
                                
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Transaction Number</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $transaction->transaction_number }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Payment Method</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-white capitalize">{{ $transaction->payment_method }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Payment Date</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-white">
                                            {{ $transaction->payment_date ? $transaction->payment_date->format('M d, Y - g:i A') : 'N/A' }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Amount</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->amount, 0) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Customer Information -->
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Customer Information</h3>
                                
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Customer</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">{{ $transaction->user->name ?? 'Unknown User' }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->user->email ?? 'No email available' }}</p>
                                </div>
                            </div>
                            
                            <!-- Ticket Information -->
                            @if($transaction->ticket)
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Ticket Information</h3>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                        <div class="flex flex-col md:flex-row justify-between">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Ticket Number</p>
                                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $transaction->ticket->ticket_number }}</p>
                                            </div>
                                            
                                            <div class="mt-3 md:mt-0">
                                                <a href="{{ route('tickets.show', $transaction->ticket) }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:underline">
                                                    <span>View Ticket</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <hr class="my-3 border-gray-200 dark:border-gray-700">
                                        
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Event</p>
                                            <p class="text-base font-medium text-gray-900 dark:text-white">
                                                {{ $transaction->ticket->event->name ?? 'Event not available' }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $transaction->ticket->event->event_date ? $transaction->ticket->event->event_date->format('M d, Y - g:i A') : 'Date not available' }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $transaction->ticket->event->venue ?? 'Venue not available' }}
                                            </p>
                                        </div>
                                        
                                        <div class="mt-3 flex justify-between">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Ticket Type</p>
                                                <p class="text-base font-medium text-gray-900 dark:text-white capitalize">
                                                    {{ $transaction->ticket->ticket_type }}
                                                    @if($transaction->ticket->seat_number)
                                                        <span class="text-sm text-gray-500 dark:text-gray-400">(Seat: {{ $transaction->ticket->seat_number }})</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                                                <p class="text-base font-medium text-gray-900 dark:text-white">
                                                    Rp {{ number_format($transaction->ticket->price, 0) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-between">
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Transactions
                            </a>
                            
                            <div>
                                <!-- Add download receipt button or other actions here if needed -->
                                @if($transaction->payment_status == 'completed')
                                    <button class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-lg text-white hover:bg-indigo-700 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Receipt
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 