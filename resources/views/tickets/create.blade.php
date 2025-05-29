<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="max-w-3xl mx-auto">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create New Ticket</h1>
                        
                        <form action="{{ route('tickets.store') }}" method="POST">
                            @csrf
                            
                            <!-- Event Selection -->
                            <div class="mb-6">
                                <label for="event_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Select Event
                                </label>
                                <select id="event_id" name="event_id" required
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    <option value="">Select an event</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }} ({{ $event->event_date->format('M d, Y') }})</option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Ticket Type -->
                            <div class="mb-6">
                                <label for="ticket_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ticket Type
                                </label>
                                <select id="ticket_type" name="ticket_type" required
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    <option value="regular">Regular</option>
                                    <option value="vip">VIP</option>
                                    <option value="backstage">Backstage</option>
                                </select>
                                @error('ticket_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Price -->
                            <div class="mb-6">
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Price (Rp)
                                </label>
                                <input type="number" id="price" name="price" min="0" step="1000" required
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Seat Number (Optional) -->
                            <div class="mb-6">
                                <label for="seat_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Seat Number (Optional)
                                </label>
                                <input type="text" id="seat_number" name="seat_number" 
                                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                @error('seat_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors mr-4">
                                    Cancel
                                </a>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                    Create Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 