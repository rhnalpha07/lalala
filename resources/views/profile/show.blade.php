<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 flex justify-center mb-6 md:mb-0">
                            @if($user->profile_picture)
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}" class="rounded-full h-64 w-64 object-cover shadow-lg">
                            @else
                                <div class="rounded-full h-64 w-64 bg-gray-200 flex items-center justify-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="md:w-2/3 md:pl-8">
                            <h2 class="text-2xl font-bold mb-4">{{ $user->name }}</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="font-medium">{{ $user->email }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600">Phone Number</p>
                                    <p class="font-medium">{{ $user->phone_number ?? 'Not provided' }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600">Address</p>
                                    <p class="font-medium">{{ $user->address ?? 'Not provided' }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600">Birth Date</p>
                                    <p class="font-medium">{{ $user->birth_date ? date('F j, Y', strtotime($user->birth_date)) : 'Not provided' }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-1">Bio</p>
                                <p class="bg-gray-50 p-4 rounded-lg">{{ $user->bio ?? 'No bio provided.' }}</p>
                            </div>
                            
                            <div class="flex space-x-4">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Edit Profile') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 