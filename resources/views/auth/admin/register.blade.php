<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white shadow-2xl rounded-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-center text-indigo-800 mb-6">Create Admin Account</h2>

                <form method="POST" action="{{ route('admin.register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="name" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   transition duration-300 ease-in-out" 
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            required 
                            autofocus 
                            autocomplete="name" 
                            placeholder="Enter admin full name"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="email" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   transition duration-300 ease-in-out" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autocomplete="username" 
                            placeholder="Enter admin email address"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="password" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   transition duration-300 ease-in-out" 
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password" 
                            placeholder="Create a strong password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="password_confirmation" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   transition duration-300 ease-in-out" 
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password" 
                            placeholder="Confirm password"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Admin Key -->
                    <div>
                        <x-input-label for="admin_key" :value="__('Admin Registration Key')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input 
                            id="admin_key" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   transition duration-300 ease-in-out" 
                            type="text"
                            name="admin_key"
                            required 
                            placeholder="Enter admin registration key"
                        />
                        <x-input-error :messages="$errors->get('admin_key')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent 
                                                rounded-lg shadow-sm text-sm font-medium text-white 
                                                bg-indigo-600 hover:bg-indigo-700 focus:outline-none 
                                                focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                                transition duration-300 ease-in-out">
                            {{ __('Register Admin') }}
                        </x-primary-button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">
                            Already have an admin account? 
                            <a href="{{ route('admin.login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                Login here
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout> 