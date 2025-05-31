<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Transactions</h2>
                    <a href="{{ route('transactions.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        New Transaction
                    </a>
                </div>

                <!-- Filter Section -->
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                    <form action="{{ route('transactions.index') }}" method="GET" class="flex flex-wrap gap-4">
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Status</label>
                            <select id="payment_status" name="payment_status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-full">
                                <option value="">All Status</option>
                                <option value="pending" @if(request('payment_status') == 'pending') selected @endif>Pending</option>
                                <option value="completed" @if(request('payment_status') == 'completed') selected @endif>Completed</option>
                                <option value="failed" @if(request('payment_status') == 'failed') selected @endif>Failed</option>
                                <option value="refunded" @if(request('payment_status') == 'refunded') selected @endif>Refunded</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-full">
                                <option value="">All Methods</option>
                                <option value="credit_card" @if(request('payment_method') == 'credit_card') selected @endif>Credit Card</option>
                                <option value="bank_transfer" @if(request('payment_method') == 'bank_transfer') selected @endif>Bank Transfer</option>
                                <option value="e-wallet" @if(request('payment_method') == 'e-wallet') selected @endif>E-Wallet</option>
                                <option value="dummy" @if(request('payment_method') == 'dummy') selected @endif>Dummy (Testing)</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Filter
                            </button>
                            @if(request('payment_status') || request('payment_method'))
                                <a href="{{ route('transactions.index') }}" class="ml-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Transactions List -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Transaction #
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Event
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Payment Method
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $transaction->transaction_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $transaction->user->name ?? 'Unknown User' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        @if($transaction->ticket && $transaction->ticket->event)
                                            <a href="{{ route('events.show', ['event' => $transaction->ticket->event->id]) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                                {{ $transaction->ticket->event->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        Rp {{ number_format($transaction->amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white capitalize">
                                        {{ $transaction->payment_method }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($transaction->payment_status == 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        @elseif($transaction->payment_status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($transaction->payment_status == 'failed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Failed
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($transaction->payment_status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $transaction->payment_date ? $transaction->payment_date->format('M d, Y H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 whitespace-nowrap text-center text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-12 h-12 mb-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                        No transactions found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 